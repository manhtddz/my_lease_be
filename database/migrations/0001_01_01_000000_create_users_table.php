<?php

use App\Database\Migration\BlueprintCustom;
use App\Database\Migration\SchemaCustom;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        SchemaCustom::create('users', function (BlueprintCustom $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->integer('manager_id')->nullable();
            $table->integer('department_id')->nullable();
            $table->char('role')->default(1);
            $table->defaultFields();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        SchemaCustom::dropIfExists('users');
    }
};
