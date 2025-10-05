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

            $table->index(['membership_started_at', 'membership_expires_at'], 'membership_period_index');
            $table->index('membership_started_at');
            $table->index('membership_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('membership_period_index');
            $table->dropIndex(['membership_started_at']);
            $table->dropIndex(['membership_expires_at']);
            $table->dropForeign(['membership_id']);
            $table->dropColumn(['membership_id', 'membership_started_at', 'membership_expires_at', 'employment_status', 'is_active']);
        });
    }
};
