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
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->date('application_date')->nullable();
            $table->string('document_link')->nullable();
            $table->date('interview_date')->nullable(); // Added interview date
            $table->time('interview_time')->nullable(); // Added interview time
            $table->string('interview_location')->nullable();
            $table->enum('scholarship_status', ['not_applied', 'applied', 'interview_scheduled', 'approved', 'rejected'])->default('not_applied');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};
