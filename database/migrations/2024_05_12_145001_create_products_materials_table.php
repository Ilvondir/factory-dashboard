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
        Schema::create('products_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("product_id");
            $table->unsignedBigInteger("material_id");
            $table->foreign("product_id")->references("id")->on("products")->cascadeOnDelete();
            $table->foreign("material_id")->references("id")->on("materials")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products_materials', function (Blueprint $table) {
            $table->dropForeign("products_materials_product_id_foreign");
            $table->dropForeign("products_materials_material_id_foreign");
        });

        Schema::dropIfExists('products_materials');
    }
};
