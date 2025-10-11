<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('product_group_id')->constrained('product_groups')->restrictOnDelete();
            $table->string('name')->nullable(false)->index();
            $table->string('size', 30)->nullable(false)->index();
            $table->string('color', 30)->nullable(false)->index();
            $table->string('variant', 50)->nullable(true);
            $table->string('image')->nullable(true);
            $table->integer('price')->nullable(false);
            $table->integer('stock')->default(1);
            $table->boolean('is_active')->default(true);

            $table->unique(['product_group_id', 'color', 'size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
