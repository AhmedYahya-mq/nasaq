<?php

use App\Enums\EmploymentStatus;
use App\Enums\MembershipApplication;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول طلبات العضوية
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->foreignId('membership_id')->constrained('memberships')->onDelete('cascade');

            $table->string('national_id')->nullable();
            $table->enum('employment_status', EmploymentStatus::getValues())->nullable();
            $table->string('current_employer')->nullable();
            $table->string('scfhs_number')->nullable();
            $table->enum('status', MembershipApplication::getValues())
                  ->default(MembershipApplication::Draft);
            $table->boolean('is_resubmit')->default(false);
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            // فهارس
            $table->index('status', 'ma_status_index');
            $table->index('submitted_at', 'ma_submitted_at_index');
            $table->index('reviewed_at', 'ma_reviewed_at_index');
            $table->index(['user_id', 'status', 'submitted_at'], 'ma_user_status_submitted_index');
            $table->index(['user_id', 'membership_id', 'status', 'submitted_at'], 'ma_user_membership_status_index');
            $table->index('employment_status', 'ma_employment_status_index');
            $table->index('current_employer', 'ma_current_employer_index');
            $table->index('scfhs_number', 'ma_scfhs_number_index');
            $table->index('created_at', 'ma_created_at_index');
            $table->index('updated_at', 'ma_updated_at_index');
        });

        // جدول ملفات العضوية
        Schema::create('membership_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_application_id')
                  ->constrained('membership_applications')
                  ->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type')->nullable();
            $table->timestamps();

            // فهارس
            $table->index('created_at', 'mf_created_at_index');
            $table->index('membership_application_id', 'mf_membership_application_index');
            $table->index('file_type', 'mf_file_type_index');
            $table->index('file_name', 'mf_file_name_index');
            $table->index('file_path', 'mf_file_path_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_files');
        Schema::dropIfExists('membership_applications');
    }
};
