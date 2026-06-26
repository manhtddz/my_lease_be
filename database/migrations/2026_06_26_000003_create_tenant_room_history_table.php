<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('tenant_room_history', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->integer('tenant_id')->unsigned()->index();
            $table->integer('room_id')->unsigned()->index();
            $table->date('move_in_date');
            $table->date('move_out_date')->nullable();
            $table->unsignedTinyInteger('is_representative'); // IsPresentativeEnum
            $table->decimal('room_price_snapshot', 15, 2)->nullable();
            $table->text('note')->nullable();
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('tenant_room_history');
    }
};
