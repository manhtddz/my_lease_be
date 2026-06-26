<?php

namespace Tests\Unit\Services\Api;

use PHPUnit\Framework\TestCase;

class RenovationServiceTest extends TestCase
{
    public function test_renovation_service_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Services/Api/RenovationService.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class RenovationService extends CustomService', $content);
        $this->assertStringContainsString('use App\Repositories\Api\RenovationRepository;', $content);
        $this->assertStringContainsString('public RenovationRepository $renovationRepository', $content);
        $this->assertStringContainsString('function getListForSearch($dataSearch = [])', $content);
        $this->assertStringContainsString('function store($params)', $content);
        $this->assertStringContainsString('function getById($id)', $content);
        $this->assertStringContainsString('invoiceItems', $content);
        $this->assertStringContainsString('function update($id, $params)', $content);
        $this->assertStringContainsString('function delete($id)', $content);
    }
}
