<?php

namespace Tests\Unit\Repositories\Api;

use PHPUnit\Framework\TestCase;

class RoomConsumptionRepositoryTest extends TestCase
{
    public function test_room_consumption_repository_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Repositories/Api/RoomConsumptionRepository.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class RoomConsumptionRepository extends CustomRepository', $content);
        $this->assertStringContainsString('protected $model = RoomConsumption::class;', $content);
        $this->assertStringContainsString("data_get(\$dataSearch, 'note')", $content);
        $this->assertStringContainsString("whereLike(\$this->modelField('note')", $content);
        $this->assertStringContainsString("data_get(\$dataSearch, 'billing_month')", $content);
        $this->assertStringContainsString('paginate(getConstant(\'PER_PAGE_DEFAULT\'))', $content);
    }
}
