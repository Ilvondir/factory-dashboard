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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->text("operation");
            $table->dateTime('occured');
            $table->unsignedBigInteger("user_id")->nullable();
            $table->foreign('user_id')->references("id")->on("users")->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->dropForeign("logs_user_id_foreign");
        });
        Schema::dropIfExists('logs');
    }
};
