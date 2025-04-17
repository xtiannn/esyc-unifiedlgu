<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run()
    {
        $users = User::all(); // Get all users

        // If no users exist, create a default one
        if ($users->isEmpty()) {
            $users = collect([
                User::create([
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'mobile' => '09099980090',
                    'email' => 'test@example.com',
                    'password' => bcrypt('password')
                ])
            ]);
        }

        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'System Update',
                'message' => 'The system will be under maintenance tonight from 12 AM to 3 AM.',
                'type' => 'info',
                'is_read' => false,
            ]);

            Notification::create([
                'user_id' => $user->id,
                'title' => 'New Feature',
                'message' => 'We have introduced a new dashboard feature. Check it out!',
                'type' => 'success',
                'is_read' => false,
            ]);

            Notification::create([
                'user_id' => null, // System-wide notification
                'title' => 'Emergency Alert',
                'message' => 'There is a scheduled power outage in some areas.',
                'type' => 'warning',
                'is_read' => false,
            ]);
        }
    }
}
