<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->unsignedBigInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropForeign('positions_department_id_foreign');
        });

        Schema::dropIfExists('departments');
    }
};
