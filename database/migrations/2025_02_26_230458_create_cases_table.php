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
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_title');
            $table->enum('case_type', ['abuse', 'neglect', 'support', 'other'])->default('other');
            $table->string('guardian_name')->nullable();
            $table->string('guardian_contact', 50)->nullable();
            $table->text('notes')->nullable();
            $table->string('user_id_file')->nullable();
            $table->integer('user_age')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->enum('status', ['open', 'in_progress', 'resolved', 'closed'])->default('open');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cases');
    }
};
