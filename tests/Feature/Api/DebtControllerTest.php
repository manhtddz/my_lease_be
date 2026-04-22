<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class DebtControllerTest extends TestCase
{
    public function test_debt_controller_and_form_requests_contract_exist(): void
    {
        $controllerPath = base_path('app/Http/Controllers/Api/DebtController.php');
        $createRequestPath = base_path('app/Validators/Api/Debt/DebtCreateFormRequest.php');
        $updateRequestPath = base_path('app/Validators/Api/Debt/DebtUpdateFormRequest.php');

        $this->assertFileExists($controllerPath);
        $this->assertFileExists($createRequestPath);
        $this->assertFileExists($updateRequestPath);
    }
}
