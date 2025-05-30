<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\ScheduleSetting;
use App\Services\SMSService;
use App\Models\SmsConfiguration;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Schedule fees reminder
        $schedule_setting = ScheduleSetting::where('slug', 'fees-schedule')->first();
        if (isset($schedule_setting)) {
            if ($schedule_setting->time) {
                $schedule->command('fees:reminder')
                    ->dailyAt($schedule_setting->time);
            } else {
                $schedule->command('fees:reminder')
                    ->dailyAt('00:01');
            }
        }

        // Schedule notice send
        $schedule->command('notice:send')
            ->dailyAt('01:01');

        // Schedule content send
        $schedule->command('content:send')
            ->dailyAt('02:01');

        // Schedule SMS low credit alert
        $schedule->call(function () {
            $smsService = app(SMSService::class);
            $smsConfig = SmsConfiguration::first(); // Fetch the SMS configuration from the database
            if ($smsConfig) {
                $apiKey = $smsConfig->api_key;
                $smsService->alertIfLowCredit($apiKey);
            }
        })->daily();


        // $schedule->call(function () { $smsService = app(SMSService::class);
        //      $smsConfig = SmsConfiguration::first(); // Fetch the SMS configuration from the database if ($smsConfig) { $apiKey = $smsConfig->api_key; $creditBalance = $smsService->checkBalance($apiKey); dd('Scheduled Task Running. Credit Balance: ' . $creditBalance); }
        //      else { dd('No SMS configuration found.'); } })->daily();



    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
