<?php
// database\migrations\2025_05_08_004557_scholarship_status.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarship_status', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['open', 'closed'])->default('open');
            $table->timestamps();
        });

        // Insert initial status
        DB::table('scholarship_status')->insert([
            'status' => 'open',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarship_status');
    }
};
