<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Enums\AccountLockFlagEnum;
use App\Http\Controllers\Admin\BaseAdminController;
use App\Repositories\AccountRepository;
use App\Services\Mail\MailService;
use App\Validators\AccountValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\MessageBag;

class LoginController extends BaseAdminController
{

    public function __construct(
        public AccountValidator $accountValidator,
        public AccountRepository $accountRepository,
        public MailService $mailService
    )
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
        $this->setTitle(__('messages.page_title.admin.login'));
    }

    public function showLoginForm()
    {
        return $this->render('auth.login.index');
    }

    public function login()
    {
        $response = ['status' => false, 'messages' => '', 'data' => [], 'redirect_url' => ''];

        if (!request()->ajax()) {
            return $this->renderJson($response);
        }

        try {
            $params = request()->all();
            $email = data_get($params, 'email');
            $password = data_get($params, 'password');

            if (!$this->accountValidator->validateLogin($params)) {
                $response['data'] = $this->accountValidator->customErrorsBag();
                return $this->renderJson($response);
            }

            // get acc by email
            $account = $this->accountRepository->getAccByEmail($email);

            // check account
            if (!$account) {
                $response = $this->newMessageError($response, ['email' => [__('auth.email_password_valid')]]);
                return $this->renderJson($response);
            }

            // check password and status
            $checkPass = Hash::check($password, $account->password);
            if (!$checkPass || !$account->isStatusEnabled()) {
                $response = $this->newMessageError($response, ['email' => [__('auth.email_password_valid')]]);
                $this->updateAcc($account);
                return $this->renderJson($response);
            }

            //case account locked
            if ($account->accountIsLocked()) {
                $response = $this->newMessageError($response, ['email' => [__('auth.lock_flag_disabled')]]);
                $response['disabled'] = true;
                return $this->renderJson($response);
            }

            if (getConfig('disable_two_factor')) {
                getGuard()->login($account);
                $response['status'] = true;
                return $this->renderJson($response);
            }

            //send mail confirm
            $this->sendMailConfirm($account);

        } catch (\Exception $exception) {
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            $response['messages'] = __('messages.system_error');
            return $this->renderJson($response);
        }

        $response['status'] = true;
        session()->put(getConstant('SESSION_LOGIN_TWO_FACTOR'), $email);
        $response['redirect_url'] = route('admin.login_twofactor');
        return $this->renderJson($response);
    }

    protected function newMessageError($response, $message = []) {
        $errors = new MessageBag($message);
        $response['data'] = $errors;
        return $response;
    }

    public function showLoginTwofactor()
    {
        if (session()->get(getConstant('SESSION_LOGIN_TWO_FACTOR'))) {
            return $this->render('auth.login.login_twofactor');
        }

        return redirect()->route('admin.login');
    }



    public function loginTwoFactor()
    {
        $response = ['status' => false, 'messages' => '', 'data' => [], 'redirect_url' => ''];

        if (!request()->ajax()) {
            return $this->renderJson($response);
        }

        try {
            $params = request()->all();
            $authCode = data_get($params, 'auth_code');
            $email = session()->get(getConstant('SESSION_LOGIN_TWO_FACTOR'));

            if (!$this->accountValidator->validateTwoFactor($params)) {
                $response['data'] = $this->accountValidator->customErrorsBag();
                return $this->renderJson($response);
            }

            $account = $this->accountRepository->checkCodeExpire($email, $authCode);
            if (empty($account)) {
                $response = $this->newMessageError($response, ['auth_code' => [__('auth.auth_code_expired')]]);
                return $this->renderJson($response);
            }

            getGuard()->login($account);
            session()->forget(getConstant('SESSION_LOGIN_TWO_FACTOR'));

            $account->fill([
                'lock_flag' => 0,
                'error_count' => 0,
                'error_datetime' => null,
                'auth_code' => null,
                'auth_code_expire' => null,
                'last_login_datetime' => Carbon::now(),
            ])->save();


        } catch (\Exception $exception) {
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            $response['messages'] = __('messages.system_error');
            return $this->renderJson($response);
        }

        $response['status'] = true;
        $response['redirect_url'] = getRoute('dashboard.index');
        return $this->renderJson($response);
    }

    public function resendAuthCode() {
        try {
            $email = session()->get(getConstant('SESSION_LOGIN_TWO_FACTOR'));
            $account = $this->accountRepository->getAccByEmail($email);

            if (data_get($account, 'auth_code_expire') && Carbon::parse($account->auth_code_expire)->subMinutes(9)->gte(Carbon::now())) {
                $errors = new MessageBag(['auth_code' => [__('messages.failed')]]);
                return redirect()->back()
                    ->withErrors($errors)
                    ->withInput(request()->all());
            }

            if ($account) {
                $this->sendMailConfirm($account);
                session()->flash('success', __('messages.send_success'));
                return redirect()->back();
            }
        } catch (\Exception $exception) {
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            $response['messages'] = __('messages.system_error');
            return $this->renderJson($response);
        }
    }

    public function logout()
    {
        getGuard()->logout();
        return redirect(getRoute('login'));
    }

    public function updateAcc(&$account) {
        if ($account->accountIsLocked()) {
            return;
        }

        if (data_get($account, 'error_count') < 6) {
            $account->error_count += 1;
            $account->error_datetime = now();
        } else {
            $account->lock_flag = AccountLockFlagEnum::LOCK;
            $account->error_datetime = now();
        }

        return $account->save();
    }

    public function sendMailConfirm(&$account) {
        DB::beginTransaction();
        try {
            $account->fill([
                'auth_code' => random_int(10000000, 99999999),
                'auth_code_expire' => Carbon::now()->addMinutes(10)->format('Y-m-d H:i:s')
            ])->save();

            $dataView = [
                'account' => $account,
                'loginUrl' => route('admin.login')
            ];

            $dataMail = [
                'to' => $account->email,
                'subject' => getConfig('mail_login_confirm_subject')
            ];

            //send mail
            $this->mailService->sendMailWithSmtp('admin.emails.login_confirm', $dataView, $dataMail);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            $response['messages'] = __('messages.system_error');
            return $this->renderJson($response);
        }
    }
}
