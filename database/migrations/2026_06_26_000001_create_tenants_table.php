<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        SchemaCustom::create('tenants', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('phone_number', 30);
            $table->string('id_card_number', 30);
            $table->defaultFields();
        });
    }

    public function down(): void
    {
        SchemaCustom::dropIfExists('tenants');
    }
};
