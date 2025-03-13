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
            'name' => 'Test User',
            'email' => 'test@example.com',
<<<<<<< HEAD
            'role' => 'User',
        ]);

        // Call other seeders
=======
            'role' => 'Admin',
        ]);

>>>>>>> 4f884247dfbb8e00b14b1b244ef5083d2e788718
        $this->call(AnnouncementSeeder::class);
        $this->call(NotificationSeeder::class);
    }


}
