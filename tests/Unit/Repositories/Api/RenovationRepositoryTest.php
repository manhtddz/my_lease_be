<?php

namespace Tests\Unit\Repositories\Api;

use PHPUnit\Framework\TestCase;

class RenovationRepositoryTest extends TestCase
{
    public function test_renovation_repository_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Repositories/Api/RenovationRepository.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class RenovationRepository extends CustomRepository', $content);
        $this->assertStringContainsString('protected $model = Renovation::class;', $content);
        $this->assertStringContainsString("data_get(\$dataSearch, 'name')", $content);
        $this->assertStringContainsString("whereLike(\$this->modelField('name')", $content);
        $this->assertStringContainsString("data_get(\$dataSearch, 'status')", $content);
        $this->assertStringContainsString('paginate(getConstant(\'PER_PAGE_DEFAULT\'))', $content);
    }
}
