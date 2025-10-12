<?php

use App\Enums\LibraryStatus;
use App\Enums\LibraryType;
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
        Schema::create('libraries', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique();
            $table->date('published_at')->nullable();
            $table->enum('status', LibraryStatus::getValues())->default(LibraryStatus::Draft);
            $table->enum('type', LibraryType::getValues())->default(LibraryType::Ebook);
            $table->integer('price')->default(0);
            $table->decimal('discount')->default(0);
            $table->string('path');
            $table->string('poster')->nullable();
            $table->timestamps();
        });

        Schema::create('libraries_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_id')->constrained('libraries')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained('payments')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libraries_users');
        Schema::dropIfExists('libraries');
    }
};
