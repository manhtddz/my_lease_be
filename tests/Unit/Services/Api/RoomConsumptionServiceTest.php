<?php

namespace Tests\Unit\Services\Api;

use PHPUnit\Framework\TestCase;

class RoomConsumptionServiceTest extends TestCase
{
    public function test_room_consumption_service_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Services/Api/RoomConsumptionService.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class RoomConsumptionService extends CustomService', $content);
        $this->assertStringContainsString('use App\Repositories\Api\RoomConsumptionRepository;', $content);
        $this->assertStringContainsString('public RoomConsumptionRepository $roomConsumptionRepository', $content);
        $this->assertStringContainsString('function getListForSearch($dataSearch = [])', $content);
        $this->assertStringContainsString('function store($params)', $content);
        $this->assertStringContainsString('function getById($id)', $content);
        $this->assertStringContainsString('function update($id, $params)', $content);
        $this->assertStringContainsString('function delete($id)', $content);
    }
}
