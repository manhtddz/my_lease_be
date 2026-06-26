<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('invoice_items', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->integer('invoice_id')->unsigned()->index();
            $table->integer('debt_id')->unsigned()->nullable()->index();
            $table->integer('renovation_id')->unsigned()->nullable()->index();
            $table->integer('room_consumption_id')->unsigned()->nullable()->index();
            $table->unsignedTinyInteger('item_type'); // 1.Electricity 2.Water 3.Occupied 4.Debt 5.Renovation
            $table->string('item_name');
            $table->decimal('amount', 15, 2);
            $table->text('note')->nullable();
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('invoice_items');
    }
};
