<?php

use App\Enums\EventCategory;
use App\Enums\EventMethod;
use App\Enums\EventStatus;
use App\Enums\EventType;
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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->integer('price')->default(0);
            $table->decimal('discount')->default(0);
            $table->enum('event_type', EventType::getValues())->default(EventType::Virtual);
            $table->enum('event_category', EventCategory::getValues())->nullable();
            $table->enum('event_method', EventMethod::getValues())->nullable();
            $table->string('link')->nullable();
            $table->enum('event_status', EventStatus::getValues())->default(EventStatus::Upcoming);
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->integer('capacity')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('event_membership', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('membership_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_attended')->default(false);
            $table->timestamp('joined_at')->nullable();
            $table->string('join_ip')->nullable();
            $table->string('join_link')->nullable();
            $table->timestamps();
            $table->unique(['event_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
        Schema::dropIfExists('event_membership');
        Schema::dropIfExists('events');
    }
};
