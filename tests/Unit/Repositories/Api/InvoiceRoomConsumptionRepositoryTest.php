<?php

namespace Tests\Unit\Repositories\Api;

use PHPUnit\Framework\TestCase;

class InvoiceRoomConsumptionRepositoryTest extends TestCase
{
    public function test_invoice_room_consumption_repository_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Repositories/Api/InvoiceRoomConsumptionRepository.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class InvoiceRoomConsumptionRepository extends CustomRepository', $content);
        $this->assertStringContainsString('protected $model = InvoiceRoomConsumption::class;', $content);
    }
}
