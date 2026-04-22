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
    }
}
