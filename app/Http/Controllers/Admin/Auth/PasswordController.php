<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Admin\BaseAdminController;
use App\Mail\Admin\PasswordForgotMail;
use App\Repositories\AccountRepository;
use App\Repositories\PasswordResetRepository;
use App\Validators\AccountValidator;
use App\Validators\PasswordResetValidator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PasswordController extends BaseAdminController
{
    /** @var AccountValidator $accountValidator */
    protected $accountValidator;
    /** @var PasswordResetValidator $passwordResetValidator */
    protected $passwordResetValidator;
    /** @var AccountRepository $accountRepository */
    protected $accountRepository;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
        $this->accountValidator = app(AccountValidator::class);
        $this->passwordResetValidator = app(PasswordResetValidator::class);
        $this->repository = app(PasswordResetRepository::class);
        $this->accountRepository = app(AccountRepository::class);
    }

    public function forgot()
    {
        $this->setTitle(__('messages.page_title.admin.forgot_password'));
        return $this->render('auth.forgot.index');
    }

    public function postForgot()
    {
        $response = ['status' => false, 'messages' => '', 'data' => [], 'redirect_url' => ''];

        if (!request()->ajax()) {
            return $this->renderJson($response);
        }

        $params = request()->all();

        if (!$this->accountValidator->validateForgotPassword($params)) {
            $response['data'] = $this->accountValidator->customErrorsBag();
            return $this->renderJson($response);
        }

        $email = data_get($params, 'email');
        $expiredTime = Carbon::now()->addMinutes(getConfig('password_reset_expired_time'))->format('Y-m-d H:i:s');
        $token = md5($email . '_' . $expiredTime . '_' . rand(0, 999999));

        $save = [
            'email' => $email,
            'token' => $token,
            'expired_time' => $expiredTime,
        ];

        if (!$this->passwordResetValidator->validateCreate($save)) {
            $msg = $this->passwordResetValidator->customErrorsBag();
            $response['data'] = ['email' => reset($msg)];
            return $this->renderJson($response);
        }

        $adminUser = $this->accountRepository->where('email', '=', $email)->first();

        DB::beginTransaction();
        try {
            // create record
            $this->repository->create($save);

            // send mail
            $dataEmail = [
                'user' => ['name' => $adminUser->name],
                'link' => getRoute('password.reset', ['token' => $token]),
                'expired_time' => $expiredTime,
            ];

            Mail::to($email)->send(new PasswordForgotMail($dataEmail));

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            $response['messages'] = __('messages.system_error');
            return $this->renderJson($response);
        }

        $response['status'] = true;
        $response['redirect_url'] = getRoute('password.forgotComplete');
        return $this->renderJson($response);
    }

    public function forgotComplete()
    {
        $this->setTitle(__('messages.page_title.admin.forgot_password'));
        return $this->render('auth.forgot.complete');
    }

    public function reset()
    {
        $this->setTitle(__('messages.page_title.admin.reset_password'));

        $token = request()->get('token');

        if (empty($token)) {
            abort(404);
        }

        $passwordResets = $this->repository->where('token', '=', $token)->first();
        if (empty($passwordResets) || Carbon::parse($passwordResets->expired_time)->lessThanOrEqualTo(Carbon::now())) {
            if (!empty($passwordResets)) {
                $this->repository->where('id', '=', $passwordResets->id)->delete();
            }
            abort(404);
        }

        return $this->render('auth.reset.index');
    }

    public function postReset()
    {
        $response = ['status' => false, 'messages' => '', 'data' => [], 'redirect_url' => ''];

        if (!request()->ajax()) {
            return $this->renderJson($response);
        }

        $params = request()->all();

        if (!$this->accountValidator->validateResetPassword($params)) {
            $response['data'] = $this->accountValidator->customErrorsBag();
            return $this->renderJson($response);
        }

        $passwordResets = $this->repository->where('token', '=', data_get($params, 'token'))
            ->where('expired_time', '>=', date('Y-m-d H:i:s'))
            ->first();

        if (empty($passwordResets)) {
            $response['messages'] = __('messages.token_expiration');
            return $this->renderJson($response);
        }

        $adminUsers = $this->accountRepository->where('email', '=', $passwordResets->email)->first();
        if (empty($adminUsers)) {
            $response['messages'] = __('messages.record_does_not_exists');
            return $this->renderJson($response);
        }

        DB::beginTransaction();
        try {
            // update password
            $this->accountRepository->where('id', '=', $adminUsers->id)
                ->update(['password' => bcrypt($params['password'])]);

            // remove record password_resets
            $this->repository->where('id', '=', $passwordResets->id)->delete();

            // send mail here ...
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            $response['messages'] = __('messages.system_error');
            return $this->renderJson($response);
        }

        $response['status'] = true;
        $response['redirect_url'] = getRoute('password.resetComplete');
        return $this->renderJson($response);
    }

    public function resetComplete()
    {
        $this->setTitle(__('messages.page_title.admin.reset_password'));
        return $this->render('auth.reset.complete');
    }
}
