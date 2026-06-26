<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('room_consumptions', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->integer('room_id')->unsigned()->index();
            $table->integer('billing_year');
            $table->unsignedTinyInteger('billing_month');
            $table->decimal('electricity_old', 15, 2);
            $table->decimal('electricity_new', 15, 2);
            $table->decimal('electricity_unit_price', 15, 2);
            $table->decimal('water_old', 15, 2);
            $table->decimal('water_new', 15, 2);
            $table->decimal('water_unit_price', 15, 2);
            $table->date('start_occupied_date')->nullable();
            $table->date('stop_occupied_date')->nullable();
            $table->decimal('occupied_unit_price', 15, 2)->nullable();
            $table->text('note')->nullable();
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('room_consumptions');
    }
};
