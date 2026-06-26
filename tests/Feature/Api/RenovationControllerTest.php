<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

class RenovationControllerTest extends TestCase
{
    public function test_renovation_controller_and_form_requests_contract_exist(): void
    {
        $this->assertFileExists(base_path('app/Http/Controllers/Api/RenovationController.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Renovation/RenovationCreateFormRequest.php'));
        $this->assertFileExists(base_path('app/Validators/Api/Renovation/RenovationUpdateFormRequest.php'));
    }
}
