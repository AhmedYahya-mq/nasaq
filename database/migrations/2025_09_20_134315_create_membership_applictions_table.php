<?php

use App\Enums\EmploymentStatus;
use App\Enums\MembershipApplication;
use App\Enums\MembershipStatus;
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
        // جدول طلبات العضوية
        Schema::create('membership_applications', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->nullOnDelete();
            $table->foreignId('membership_id')->constrained('memberships')->onDelete('cascade'); // نوع العضوية المطلوبة
            $table->string('national_id')->nullable();
            $table->enum('employment_status', EmploymentStatus::getValues())->nullable();
            $table->string('current_employer')->nullable();
            $table->string('scfhs_number')->nullable();
            $table->enum('status', MembershipApplication::getValues())
                ->default(MembershipApplication::Draft)->change();
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            // indexes
            $table->index('status');
            $table->index('submitted_at');
            $table->index('reviewed_at');
            $table->index(['user_id', 'status', 'submitted_at'], 'user_status_submitted_index');
            $table->index(['user_id', 'membership_id', 'status', 'submitted_at'], 'user_status_submitted_index');
            $table->index('employment_status');
            $table->index('current_employer');
            $table->index('scfhs_number');
            $table->index('created_at');
            $table->index('updated_at');
        });

        // جدول ملفات العضوية
        Schema::create('membership_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membership_application_id')
                ->constrained('membership_applications')
                ->onDelete('cascade'); // ربط بالطلب
            $table->string('file_name'); // اسم الملف الأصلي
            $table->string('file_path'); // المسار في السيرفر أو التخزين
            $table->string('file_type')->nullable(); // نوع الملف (pdf, jpg, png...)
            $table->timestamps();

            // indexes
            $table->index('created_at');
            $table->index('membership_application_id');
            $table->index('file_type');
            $table->index('file_name');
            $table->index('file_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('membership_files');
        Schema::dropIfExists('membership_applications');
    }
};
