<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class TenantRoomHistoryControllerTest extends TestCase
{
    public function test_tenant_room_history_controller_and_form_requests_contract_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/TenantRoomHistoryController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/TenantRoomHistory/TenantRoomHistoryCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/TenantRoomHistory/TenantRoomHistoryUpdateFormRequest.php'));
        $this->assertFileExists(base_path('app/Services/Api/TenantRoomHistoryService.php'));
    }
}
