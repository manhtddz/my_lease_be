<?php

namespace Tests\Unit\Repositories\Api;

use PHPUnit\Framework\TestCase;

class DebtRepositoryTest extends TestCase
{
    public function test_debt_repository_contract_is_defined(): void
    {
        $path = __DIR__ . '/../../../../app/Repositories/Api/DebtRepository.php';
        $this->assertFileExists($path);

        $content = file_get_contents($path);
        $this->assertIsString($content);
        $this->assertStringContainsString('class DebtRepository extends CustomRepository', $content);
        $this->assertStringContainsString('protected $model = Debt::class;', $content);
        $this->assertStringContainsString("data_get(\$dataSearch, 'note')", $content);
        $this->assertStringContainsString("whereLike(\$this->modelField('note')", $content);
        $this->assertStringContainsString("data_get(\$dataSearch, 'status')", $content);
        $this->assertStringContainsString('paginate(getConstant(\'PER_PAGE_DEFAULT\'))', $content);
    }
}
