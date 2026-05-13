<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class InvoiceItemControllerTest extends TestCase
{
    public function test_invoice_item_stack_files_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/InvoiceItemController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/InvoiceItem/InvoiceItemCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/InvoiceItem/InvoiceItemUpdateFormRequest.php'));
    }
}
