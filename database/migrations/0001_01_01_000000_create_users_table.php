<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('external_id')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('email', 191)->unique();
            $table->string('password');
            $table->date('birth_date')->nullable();
            $table->enum('sex', ['MALE', 'FEMALE', 'OTHER'])->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('city')->nullable();
            $table->string('house')->nullable();
            $table->string('street')->nullable();
            $table->string('barangay')->nullable();
            $table->enum('working', ['yes', 'no'])->nullable();
            $table->string('occupation')->nullable();
            $table->boolean('verified')->default(false);
            $table->string('reset_token')->nullable();
            $table->dateTime('reset_token_expiry')->nullable();
            $table->string('otp', 6)->nullable();
            $table->dateTime('otp_expiry')->nullable();
            $table->string('session_token')->nullable();
            $table->enum('role', ['User', 'Admin', 'Super Admin']);
            $table->string('session_id')->nullable();
            $table->dateTime('last_activity')->nullable();
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
