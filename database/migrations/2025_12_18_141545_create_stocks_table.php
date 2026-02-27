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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->date('date')->nullable();
            $table->date('last_change_date')->nullable();
            $table->binary('supplier_article', 8, true)->nullable();
            $table->binary('tech_size', 8, true)->nullable();
            $table->unsignedBigInteger('barcode')->nullable();
            $table->unsignedMediumInteger('quantity')->nullable();
            $table->boolean('is_supply')->nullable();
            $table->boolean('is_realization')->nullable();
            $table->unsignedMediumInteger('quantity_full')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->unsignedMediumInteger('in_way_to_client')->nullable();
            $table->unsignedMediumInteger('in_way_from_client')->nullable();
            $table->unsignedInteger('nm_id')->nullable();
            $table->binary('subject', 8, true)->nullable();
            $table->binary('category', 8, true)->nullable();
            $table->binary('brand', 8, true)->nullable();
            $table->unsignedInteger('sc_code')->nullable();
            $table->decimal('price')->nullable();
            $table->unsignedTinyInteger('discount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
