<?php

namespace App\Http\Controllers\Web;

class HomeController extends BaseWebController
{
    public function __construct(
    )
    {
        parent::__construct();
    }

    public function index()
    {
        return redirect(route('admin.home'));
    }

    public function demo()
    {
        return $this->render();
    }
}
