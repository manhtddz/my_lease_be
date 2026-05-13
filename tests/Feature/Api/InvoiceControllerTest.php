<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    public function test_invoice_controller_and_form_requests_contract_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/InvoiceController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Invoice/InvoiceCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Invoice/InvoiceUpdateFormRequest.php'));

        $create = file_get_contents(base_path('app/Validators/Api/Invoice/InvoiceCreateFormRequest.php'));
        $this->assertStringContainsString("'total_amount'", $create);
        $this->assertStringNotContainsString('room_consumption_id', $create);
    }
}
