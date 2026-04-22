<?php

namespace Tests\Unit\Services\Api;

use PHPUnit\Framework\TestCase;

class RoomSidePaidServiceTest extends TestCase
{
    public function test_room_side_paid_service_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Services/Api/RoomSidePaidService.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class RoomSidePaidService extends CustomService', $content);
        $this->assertStringContainsString('use App\Repositories\Api\RoomSidePaidRepository;', $content);
        $this->assertStringContainsString('public RoomSidePaidRepository $roomSidePaidRepository', $content);
        $this->assertStringContainsString('function getListForSearch($dataSearch = [])', $content);
        $this->assertStringContainsString('function store($params)', $content);
        $this->assertStringContainsString('function getById($id)', $content);
        $this->assertStringContainsString('function update($id, $params)', $content);
        $this->assertStringContainsString('function delete($id)', $content);
    }
}
