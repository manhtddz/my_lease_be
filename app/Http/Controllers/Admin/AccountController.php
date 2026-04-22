<?php

namespace App\Http\Controllers\Admin;

class AccountController extends BaseAdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->setTitle(__('messages.page_title_admin'));
    }

    public function index()
    {
        return $this->render('account.index');
    }
}
