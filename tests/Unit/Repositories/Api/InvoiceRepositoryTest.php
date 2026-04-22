<?php

namespace Tests\Unit\Repositories\Api;

use PHPUnit\Framework\TestCase;

class InvoiceRepositoryTest extends TestCase
{
    public function test_invoice_repository_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Repositories/Api/InvoiceRepository.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class InvoiceRepository extends CustomRepository', $content);
        $this->assertStringContainsString('protected $model = Invoice::class;', $content);
        $this->assertStringContainsString("data_get(\$dataSearch, 'note')", $content);
        $this->assertStringContainsString("whereLike(\$this->modelField('note')", $content);
        $this->assertStringContainsString("data_get(\$dataSearch, 'payment_status')", $content);
        $this->assertStringContainsString('paginate(getConstant(\'PER_PAGE_DEFAULT\'))', $content);
    }
}
