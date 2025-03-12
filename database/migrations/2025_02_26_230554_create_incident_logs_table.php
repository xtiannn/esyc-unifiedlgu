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
        Schema::create('incident_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('reported_by');
            $table->string('incident_type', 100);
            $table->text('description');
            $table->string('media_type', 20)->nullable();
            $table->string('media_path', 255)->nullable();
            $table->enum('status', ['pending', 'resolved', 'closed'])->default('pending');
            $table->string('location', 255)->nullable();
            $table->dateTime('incident_date')->default(now());
            $table->timestamps();


            $table->foreign('reported_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_logs');
    }
};
