<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->bigInteger('photoable_id')->nullable()->after('id');
            $table->string('photoable_type')->nullable()->after('photoable_id');
        });
    }

    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn(['photoable_id', 'photoable_type']);
        });
    }
};
