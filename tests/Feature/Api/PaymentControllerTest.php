<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class PaymentControllerTest extends TestCase
{
    public function test_payment_controller_and_form_requests_contract_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/PaymentController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Payment/PaymentCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Payment/PaymentUpdateFormRequest.php'));
    }
}
