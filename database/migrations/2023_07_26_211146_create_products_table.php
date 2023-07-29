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
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->unsignedBigInteger('stock')->default(0);
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedBigInteger('sale_price')->default(0);
            $table->string('description')->nullable();
            $table->text('content')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->integer('is_active')->default(1);
            $table->integer('is_hot')->default(0);
            $table->integer('is_feature')->default(0);
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories');        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
