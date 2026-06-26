<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('renovations', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned()->index();
            $table->integer('tenant_id')->unsigned()->index();
            $table->string('name');
            $table->decimal('amount', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('remaining_amount', 15, 2)->nullable();
            $table->date('issue_date');
            $table->unsignedTinyInteger('paid_by'); // 1. Owner, 2. Tenant
            $table->unsignedTinyInteger('status'); // ActiveStatusEnum: 1. Active, 0. Cancelled
            $table->text('note')->nullable();
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('renovations');
    }
};
