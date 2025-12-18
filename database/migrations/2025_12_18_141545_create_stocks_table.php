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
            $table->timestamp('date');
            $table->timestamp('last_change_date');
            $table->string('supplier_article');
            $table->string('tech_size');
            $table->bigInteger('barcode');
            $table->unsignedMediumInteger('quantity');
            $table->boolean('is_supply');
            $table->boolean('is_realization');
            $table->unsignedMediumInteger('quantity_full');
            $table->string('warehouse_name');
            $table->unsignedMediumInteger('in_way_to_client');
            $table->unsignedMediumInteger('in_way_from_client');
            $table->unsignedInteger('nm_id');
            $table->string('subject');
            $table->string('category');
            $table->string('brand');
            $table->integer('sc_code');
            $table->string('price');
            $table->unsignedTinyInteger('discount');
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
