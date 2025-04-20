<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $chairman = User::where('role', 'Chairman')->first();
            if ($chairman) {
                $chairman->notify(new \App\Notifications\ChairmanMonthlyDigest());
            }
        })->monthlyOn(1, '08:00');
    }
}
