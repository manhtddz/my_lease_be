<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class TenantControllerTest extends TestCase
{
    public function test_tenant_controller_and_form_requests_contract_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/TenantController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Tenant/TenantCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Tenant/TenantUpdateFormRequest.php'));
        $this->assertFileExists(base_path('app/Services/Api/TenantService.php'));
    }
}
