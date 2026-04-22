<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class RoomSidePaidControllerTest extends TestCase
{
    public function test_room_side_paid_controller_and_form_requests_contract_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/RoomSidePaidController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/RoomSidePaid/RoomSidePaidCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/RoomSidePaid/RoomSidePaidUpdateFormRequest.php'));
    }
}
