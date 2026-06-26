<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('payments', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned()->nullable()->index();
            $table->integer('tenant_id')->unsigned()->index();
            $table->integer('debt_id')->unsigned()->nullable()->index();
            $table->integer('renovation_id')->unsigned()->nullable()->index();
            $table->decimal('payment_amount', 15, 2);
            $table->dateTime('payment_date');
            $table->unsignedTinyInteger('payment_method'); // 1. banking, 2. cash
            $table->unsignedTinyInteger('status'); // ActiveStatusEnum: 1. Active, 0. Cancelled
            $table->text('note')->nullable();
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('payments');
    }
};
