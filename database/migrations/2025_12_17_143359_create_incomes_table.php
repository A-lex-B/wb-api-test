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
        Schema::create('incomes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedInteger('income_id')->nullable();
            $table->unsignedInteger('number')->nullable();
            $table->date('date')->nullable();
            $table->date('last_change_date')->nullable();
            $table->binary('supplier_article', 8, true)->nullable();
            $table->binary('tech_size', 8, true)->nullable();
            $table->unsignedBigInteger('barcode')->nullable();
            $table->unsignedMediumInteger('quantity')->nullable();
            $table->decimal('total_price', 11, 2)->nullable();
            $table->date('date_close')->nullable();
            $table->string('warehouse_name')->nullable();
            $table->unsignedInteger('nm_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
