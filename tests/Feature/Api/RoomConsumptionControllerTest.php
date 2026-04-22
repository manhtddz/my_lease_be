<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class RoomConsumptionControllerTest extends TestCase
{
    public function test_room_consumption_controller_and_form_requests_contract_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/RoomConsumptionController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/RoomConsumption/RoomConsumptionCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/RoomConsumption/RoomConsumptionUpdateFormRequest.php'));
    }
}
