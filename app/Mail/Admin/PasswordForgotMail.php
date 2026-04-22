<?php

namespace App\Mail\Admin;

use Core\Mail\BaseMail;

class PasswordForgotMail extends BaseMail
{
    public function __construct($data)
    {
        parent::__construct($data);

        $this->subject = __('messages.subject_mails.password.forgot');

        $this->view = 'admin.emails.password_forgot';

        // $this->from[] = ['address' => env('MAIL_FROM_ADDRESS'), 'name' => env('MAIL_FROM_NAME')];

        // $this->replyTo[] = ['address' => 'example@lrv.test', 'name' => 'LRV ReplyTo'];

        // $this->cc[] = ['address' => 'example@lrv.test', 'name' => 'LRV CC'];

        // $this->bcc[] = ['address' => 'example@lrv.test', 'name' => 'LRV BCC'];

        // $this->attachments[] = ['file' => public_path('storage/example.pdf'), 'options' => []];
    }
}
