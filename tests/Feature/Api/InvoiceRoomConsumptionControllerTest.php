<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class InvoiceRoomConsumptionControllerTest extends TestCase
{
    public function test_invoice_room_consumption_stack_files_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/InvoiceRoomConsumptionController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/InvoiceRoomConsumption/InvoiceRoomConsumptionCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/InvoiceRoomConsumption/InvoiceRoomConsumptionUpdateFormRequest.php'));
    }
}
