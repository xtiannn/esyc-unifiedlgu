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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 191)->unique();
            $table->string('password')->nullable();
            $table->enum('role', ['User', 'Admin']);
            $table->string('reset_token')->nullable();
            $table->dateTime('reset_expires')->nullable();
            $table->string('contact_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Widowed', 'Separated', 'Divorced'])->nullable();
            $table->string('occupation')->nullable();
            $table->string('household_number', 50)->nullable();
            $table->string('barangay_id', 50)->nullable();
            $table->boolean('is_resident')->default(true);
            $table->enum('scholarship_status', ['not_applied', 'applied', 'interview_scheduled', 'approved', 'rejected'])->default('not_applied');
            $table->dateTime('application_date')->nullable();
            $table->string('document_path')->nullable();
            $table->string('profile_picture')->nullable();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
