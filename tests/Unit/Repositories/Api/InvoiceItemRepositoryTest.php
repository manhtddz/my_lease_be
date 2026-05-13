<?php

namespace Tests\Unit\Repositories\Api;

use PHPUnit\Framework\TestCase;

class InvoiceItemRepositoryTest extends TestCase
{
    public function test_invoice_item_repository_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Repositories/Api/InvoiceItemRepository.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class InvoiceItemRepository extends CustomRepository', $content);
        $this->assertStringContainsString('protected $model = InvoiceItem::class;', $content);
    }
}
