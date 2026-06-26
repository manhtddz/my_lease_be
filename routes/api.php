<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DebtController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\InvoiceItemController;
use App\Http\Controllers\Api\InvoiceRoomConsumptionController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\RoomConsumptionController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\RenovationController;
use App\Http\Controllers\Api\TenantController;
use App\Http\Controllers\Api\TenantRoomHistoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['as' => getConfig('routes.api.as')], function () {
    // Authentication routes (no authentication required)
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');

    // Protected API routes (Sanctum authentication required)
    // Route::middleware(['auth:sanctum'])->group(function () {
        // Đặt /me trước các routes khác để tránh conflict
        Route::get('/me', [AuthController::class, 'me'])->name('me');

        // Auth routes (protected)
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        // users api
        Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{id}', [UserController::class, 'show'])->name('show');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
            Route::put('/up-admin/{id}', [UserController::class, 'upToAdmin'])->name('upToAdmin');
        });

        Route::group(['as' => 'debts.', 'prefix' => 'debts'], function () {
            Route::get('/', [DebtController::class, 'index'])->name('index');
            Route::post('/', [DebtController::class, 'store'])->name('store');
            Route::get('/{id}', [DebtController::class, 'show'])->name('show');
            Route::put('/{id}', [DebtController::class, 'update'])->name('update');
            Route::delete('/{id}', [DebtController::class, 'destroy'])->name('destroy');
            Route::post('/pay/{$id}', [DebtController::class, 'payDebt'])->name('payDebt');
        });

        Route::group(['as' => 'invoices.', 'prefix' => 'invoices'], function () {
            Route::get('/', [InvoiceController::class, 'index'])->name('index');
            Route::post('/', [InvoiceController::class, 'store'])->name('store');
            Route::get('/{id}', [InvoiceController::class, 'show'])->name('show');
            Route::put('/{id}', [InvoiceController::class, 'update'])->name('update');
            Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('destroy');
            Route::post('/pay-invoices/{id}', [InvoiceController::class, 'payInvoice'])->name('payInvoice');
            Route::get('/get-by-consumption/{consumptionId}', [InvoiceController::class, 'getInvoiceByConsumption'])->name('getInvoiceByConsumption');
        });

        Route::group(['as' => 'invoiceItems.', 'prefix' => 'invoice-items'], function () {
            Route::get('/', [InvoiceItemController::class, 'index'])->name('index');
            Route::post('/', [InvoiceItemController::class, 'store'])->name('store');
            Route::get('/{id}', [InvoiceItemController::class, 'show'])->name('show');
            Route::put('/{id}', [InvoiceItemController::class, 'update'])->name('update');
            Route::delete('/{id}', [InvoiceItemController::class, 'destroy'])->name('destroy');
        });

        Route::group(['as' => 'invoiceRoomConsumptions.', 'prefix' => 'invoice-room-consumptions'], function () {
            Route::get('/', [InvoiceRoomConsumptionController::class, 'index'])->name('index');
            Route::post('/', [InvoiceRoomConsumptionController::class, 'store'])->name('store');
            Route::get('/{id}', [InvoiceRoomConsumptionController::class, 'show'])->name('show');
            Route::put('/{id}', [InvoiceRoomConsumptionController::class, 'update'])->name('update');
            Route::delete('/{id}', [InvoiceRoomConsumptionController::class, 'destroy'])->name('destroy');
        });

        Route::group(['as' => 'payments.', 'prefix' => 'payments'], function () {
            Route::get('/', [PaymentController::class, 'index'])->name('index');
            Route::post('/', [PaymentController::class, 'store'])->name('store');
            Route::get('/{id}', [PaymentController::class, 'show'])->name('show');
            Route::put('/{id}', [PaymentController::class, 'update'])->name('update');
            Route::delete('/{id}', [PaymentController::class, 'destroy'])->name('destroy');
            Route::put('/cancel/{id}', [PaymentController::class, 'cancelPayment'])->name('cancelPayment');
        });

        Route::group(['as' => 'roomConsumptions.', 'prefix' => 'room-consumptions'], function () {
            Route::get('/', [RoomConsumptionController::class, 'index'])->name('index');
            Route::post('/', [RoomConsumptionController::class, 'store'])->name('store');
            Route::get('/{id}', [RoomConsumptionController::class, 'show'])->name('show');
            Route::put('/{id}', [RoomConsumptionController::class, 'update'])->name('update');
            Route::delete('/{id}', [RoomConsumptionController::class, 'destroy'])->name('destroy');
            Route::put('/end-consumption/{id}', [RoomConsumptionController::class, 'endConsumtion'])->name('endConsumtion');
        });

        Route::group(['as' => 'renovations.', 'prefix' => 'renovations'], function () {
            Route::get('/', [RenovationController::class, 'index'])->name('index');
            Route::post('/', [RenovationController::class, 'store'])->name('store');
            Route::get('/{id}', [RenovationController::class, 'show'])->name('show');
            Route::put('/{id}', [RenovationController::class, 'update'])->name('update');
            Route::delete('/{id}', [RenovationController::class, 'destroy'])->name('destroy');
            Route::post('/pay/{$id}', [RenovationController::class, 'payRenovation'])->name('payRenovation');
        });

        Route::group(['as' => 'rooms.', 'prefix' => 'rooms'], function () {
            Route::get('/', [RoomController::class, 'index'])->name('index');
            Route::post('/', [RoomController::class, 'store'])->name('store');
            Route::get('/{id}', [RoomController::class, 'show'])->name('show');
            Route::put('/{id}', [RoomController::class, 'update'])->name('update');
            Route::delete('/{id}', [RoomController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/current-occupants', [RoomController::class, 'getCurrentOccupants'])->name('getCurrentOccupants');
            Route::put('/{roomId}/tenants/move-out', [RoomController::class, 'moveOut'])->name('moveOut');
            Route::put('/{roomId}/move-out-all', [RoomController::class, 'moveOutAll'])->name('moveOutAll');
            Route::put('/{sourceRoomId}/transfer-to/{destRoomId}', [RoomController::class, 'transferToRoom'])->name('transferToRoom');
        });

        Route::group(['as' => 'tenants.', 'prefix' => 'tenants'], function () {
            Route::get('/', [TenantController::class, 'index'])->name('index');
            Route::post('/', [TenantController::class, 'store'])->name('store');
            Route::get('/{id}', [TenantController::class, 'show'])->name('show');
            Route::put('/{id}', [TenantController::class, 'update'])->name('update');
            Route::delete('/{id}', [TenantController::class, 'destroy'])->name('destroy');
            Route::post('/store-and-assign', [TenantController::class, 'storeAndAssign'])->name('storeAndAssign');
            Route::put('/{tenantId}/{roomId}/set-representation', [TenantController::class, 'setRepresentation'])->name('setRepresentation');
            Route::post('/assign-to-room/{tenantId}/{roomId}', [TenantController::class, 'assignToRoom'])->name('assignToRoom');
        });

        Route::group(['as' => 'tenantRoomHistories.', 'prefix' => 'tenant-room-histories'], function () {
            Route::get('/', [TenantRoomHistoryController::class, 'index'])->name('index');
            Route::post('/', [TenantRoomHistoryController::class, 'store'])->name('store');
            Route::get('/{id}', [TenantRoomHistoryController::class, 'show'])->name('show');
            Route::put('/{id}', [TenantRoomHistoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [TenantRoomHistoryController::class, 'destroy'])->name('destroy');
        });
    // });
});
