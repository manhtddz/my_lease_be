<?php

namespace Tests\Unit\Services\Api;

use PHPUnit\Framework\TestCase;

class PaymentServiceTest extends TestCase
{
    public function test_payment_service_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Services/Api/PaymentService.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class PaymentService extends CustomService', $content);
        $this->assertStringContainsString('use App\Repositories\Api\PaymentRepository;', $content);
        $this->assertStringContainsString('public PaymentRepository $paymentRepository', $content);
        $this->assertStringContainsString('function getListForSearch($dataSearch = [])', $content);
        $this->assertStringContainsString('function store($params)', $content);
        $this->assertStringContainsString('function getById($id)', $content);
        $this->assertStringContainsString('function update($id, $params)', $content);
        $this->assertStringContainsString('function delete($id)', $content);
    }
}
