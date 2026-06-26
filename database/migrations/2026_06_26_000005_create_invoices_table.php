<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('invoices', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned()->index();
            $table->integer('representative_tenant_id')->unsigned()->nullable()->index();
            $table->decimal('total_amount', 15, 2)->nullable();
            $table->unsignedTinyInteger('payment_status'); // PaymentStatusEnum: 1.Initial 2.Paid 3.Partial 4.Overdue
            $table->text('note')->nullable();
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('invoices');
    }
};
