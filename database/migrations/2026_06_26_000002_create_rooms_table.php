<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('rooms', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->string('room_number', 50);
            $table->integer('floor');
            $table->unsignedTinyInteger('room_type'); // 1. Single, 2. Double, 3. Triple, 4. Quadruple, 5. Family
            $table->decimal('room_price', 15, 2);
            $table->integer('max_occupants');
            $table->unsignedTinyInteger('status'); // RoomStatusEnum: 0. Available, 1. Partially, 2. Fully, 3. Reserved
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('rooms');
    }
};
