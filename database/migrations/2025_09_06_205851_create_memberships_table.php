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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->json('name');
            $table->json('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->decimal('price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->decimal('percent_discount', 3, 2)->default(0.00);
            $table->integer('duration_days')->default(365);
            $table->json('requirements')->nullable();
            $table->json('features')->nullable();
            $table->integer('level')->default(1)->comment('1: Basic, 2: Standard, 3: Premium');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // حذف الجدول
        Schema::dropIfExists('memberships');
    }
};
