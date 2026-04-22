<?php

namespace Tests\Unit\Services\Api;

use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{
    public function test_invoice_service_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Services/Api/InvoiceService.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class InvoiceService extends CustomService', $content);
        $this->assertStringContainsString('use App\Repositories\Api\InvoiceRepository;', $content);
        $this->assertStringContainsString('public InvoiceRepository $invoiceRepository', $content);
        $this->assertStringContainsString('function getListForSearch($dataSearch = [])', $content);
        $this->assertStringContainsString('function store($params)', $content);
        $this->assertStringContainsString('function getById($id)', $content);
        $this->assertStringContainsString('function update($id, $params)', $content);
        $this->assertStringContainsString('function delete($id)', $content);
    }
}
