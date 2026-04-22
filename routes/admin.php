<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group(['as' => getConfig('routes.admin.as')], function () {
    // View routes (for browser testing)
    Route::get('/login', function () {
        return view('admin.test.login');
    })->name('login');

    // Protected routes (authentication required)
    Route::middleware(['auth:admin'])->group(function (){
        Route::get('/test/dashboard', function () {
            // dd([
            //     'auth_admin' => auth()->guard('admin')->check(),
            //     'admin_user' => auth()->guard('admin')->user(),
            //     'session_id' => session()->getId(),
            // ]);


            return view('admin.test.dashboard');
        })->name('test.dashboard');

        Route::post('/test/logout', function () {
            Auth::guard('admin')->logout();
            return response()->json([
                'status' => true,
                'message' => 'Logout successful',
            ]);
        })->name('test.logout');
    });

});
