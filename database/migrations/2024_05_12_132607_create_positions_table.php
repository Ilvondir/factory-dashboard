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
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->text("responsibilities");
        });

        Schema::table('workers', function (Blueprint $table) {
            $table->unsignedBigInteger('position_id');
            $table->foreign('position_id')->references("id")->on('positions')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workers', function (Blueprint $table) {
            $table->dropForeign('workers_position_id_foreign');
        });

        Schema::dropIfExists('positions');
    }
};
