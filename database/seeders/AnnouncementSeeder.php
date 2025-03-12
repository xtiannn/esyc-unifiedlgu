<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        Announcement::create([
            'title' => 'System Maintenance',
            'message' => 'System Maintenance on March 10, 2025, from 12 AM to 3 AM. Please be advised!',
            'published_at' => Carbon::now(),
        ]);
    }
}
