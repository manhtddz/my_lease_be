<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class RoomControllerTest extends TestCase
{
    public function test_room_controller_and_form_requests_contract_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/RoomController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Room/RoomCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Room/RoomUpdateFormRequest.php'));
        $this->assertFileExists(base_path('app/Services/Api/RoomService.php'));
    }
}
