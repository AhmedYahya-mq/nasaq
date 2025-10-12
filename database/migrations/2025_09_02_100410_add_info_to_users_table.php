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
        Schema::table('users', function (Blueprint $table) {
            $table->string('photo')->nullable()->after('email');
            $table->string('phone')->nullable()->after('photo');
            $table->date('birthday')->nullable()->after('phone');
            $table->string('address')->nullable()->after('birthday');
            $table->string('job_title')->nullable()->after('address');
            $table->text('bio')->nullable()->after('job_title');

        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['photo', 'phone', 'birthday', 'address', 'job_title', 'bio']);
        });
    }
};
