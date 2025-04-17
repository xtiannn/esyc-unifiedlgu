<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'mobile' => '09099980090',
            'email' => 'test@example.com',
            'role' => 'Admin',
        ]);

        $this->call(AnnouncementSeeder::class);
        $this->call(NotificationSeeder::class);
    }
}
