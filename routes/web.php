<?php

use Illuminate\Support\Facades\Route;

// Public web routes (no authentication required)
Route::get('/test/public', function () {
    return response()->json([
        'status' => true,
        'message' => 'This is a public web route - no authentication required',
        'area' => 'web',
    ]);
})->name('test.public');

// Protected web routes (authentication required)
Route::middleware('auth')->group(function () {
    Route::get('/test/dashboard', function () {
        $user = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'This is a protected web route - authentication required',
            'area' => 'web',
            'user' => $user ? [
                'id' => $user->id,
                'name' => $user->name ?? 'N/A',
                'email' => $user->email ?? 'N/A',
            ] : null,
        ]);
    })->name('test.dashboard');

    Route::get('/test/profile', function () {
        return response()->json([
            'status' => true,
            'message' => 'Web profile route - authentication required',
            'user' => auth()->user(),
        ]);
    })->name('test.profile');
});

// Vue SPA routes - catch-all must be at the end to allow other routes to work
Route::get('admin', function () {
    return view('frontend.admin');
})->name('frontend.admin');

Route::get('admin/{any}', function () {
    return view('frontend.admin');
})->where('any', '^(?!api|storage).*$')->name('frontend.admin.any');
