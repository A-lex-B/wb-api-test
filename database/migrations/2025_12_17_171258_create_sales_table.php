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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal('g_number', 22, 0)->nullable();
            $table->date('date')->nullable();
            $table->date('last_change_date')->nullable();
            $table->binary('supplier_article', 8, true)->nullable();
            $table->binary('tech_size', 8, true)->nullable();
            $table->unsignedBigInteger('barcode')->nullable();
            $table->decimal('total_price', 11, 2)->nullable();
            $table->unsignedTinyInteger('discount_percent')->nullable();
            $table->boolean('is_supply')->nullable();
            $table->boolean('is_realization')->nullable();
            $table->unsignedMediumInteger('promo_code_discount')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->string('country_name')->nullable();
            $table->string('oblast_okrug_name')->nullable();
            $table->string('region_name')->nullable();
            $table->unsignedInteger('income_id')->nullable();
            $table->string('sale_id')->nullable();
            $table->unsignedInteger('odid')->nullable();
            $table->unsignedTinyInteger('spp')->nullable();
            $table->decimal('for_pay')->nullable();
            $table->decimal('finished_price')->nullable();
            $table->decimal('price_with_disc')->nullable();
            $table->unsignedInteger('nm_id')->nullable();
            $table->binary('subject', 8, true)->nullable();
            $table->binary('category', 8, true)->nullable();
            $table->binary('brand', 8, true)->nullable();
            $table->boolean('is_storno')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
