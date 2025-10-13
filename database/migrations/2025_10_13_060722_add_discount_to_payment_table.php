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
        Schema::table('payments', function (Blueprint $table) {
            $table->integer('discount')->default(0)->after('amount')->comment('Discount applied to the payment');
            // خصم العضوية او
            $table->integer('membership_discount')->default(0)->after('discount')->comment('Membership discount applied to the payment');
            // السعر الاصلي
            $table->integer('original_price')->default(0)->after('membership_discount')->comment('Original price before any discounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['discount', 'membership_discount', 'original_price']);
        });
    }
};
