<?php

use App\Enums\EmploymentStatus;
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
            $table->boolean('is_active')->default(true)->after('password');
            $table->foreignId('membership_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamp('membership_started_at')->nullable();
            $table->timestamp('membership_expires_at')->nullable();
            $table->enum('employment_status', EmploymentStatus::getValues())->nullable();
            $table->string('national_id')->nullable()->after('bio');
            $table->string('current_employer')->nullable()->after('national_id');
            $table->string('scfhs_number')->nullable()->after('current_employer');

            $table->index(['membership_started_at', 'membership_expires_at'], 'membership_period_index');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('membership_period_index');
            $table->dropIndex('users_is_active_index');
            $table->dropForeign(['membership_id']);
            $table->dropColumn([
                'membership_id',
                'membership_started_at',
                'membership_expires_at',
                'employment_status',
                'is_active',
                'national_id',
                'current_employer',
                'scfhs_number'
            ]);
        });
    }
};
