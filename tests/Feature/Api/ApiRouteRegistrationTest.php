<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class ApiRouteRegistrationTest extends TestCase
{
    public function test_new_crud_routes_are_registered_in_api_file(): void
    {
        $path = base_path('routes/api.php');
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString("Route::group(['as' => 'debts.', 'prefix' => 'debts']", $content);
        $this->assertStringContainsString("Route::group(['as' => 'invoices.', 'prefix' => 'invoices']", $content);
        $this->assertStringContainsString("Route::group(['as' => 'payments.', 'prefix' => 'payments']", $content);
        $this->assertStringContainsString("Route::group(['as' => 'roomConsumptions.', 'prefix' => 'room-consumptions']", $content);
        $this->assertStringContainsString("Route::group(['as' => 'roomSidePaids.', 'prefix' => 'room-side-paids']", $content);
        $this->assertStringContainsString("Route::group(['as' => 'rooms.', 'prefix' => 'rooms']", $content);
        $this->assertStringContainsString("Route::group(['as' => 'tenants.', 'prefix' => 'tenants']", $content);
        $this->assertStringContainsString("Route::group(['as' => 'tenantRoomHistories.', 'prefix' => 'tenant-room-histories']", $content);
    }
}
