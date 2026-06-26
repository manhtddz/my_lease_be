<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('debts', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned()->index();
            $table->integer('tenant_id')->unsigned()->index();
            $table->decimal('original_amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2);
            $table->decimal('penalty_amount', 15, 2)->nullable();
            $table->unsignedTinyInteger('debt_type'); // 1: Owner Debt, 2: Tenant Debt
            $table->date('due_date');
            $table->unsignedTinyInteger('status'); // ActiveStatusEnum: 1. Active, 0. Cancelled
            $table->text('note')->nullable();
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('debts');
    }
};
