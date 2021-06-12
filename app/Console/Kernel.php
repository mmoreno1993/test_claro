<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\SendEmail;
use Illuminate\Support\Facades\Mail;
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
        Se configura cada hora para que envie los correos registrados por usuarios
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(function (){
            $sendMail = SendEmail::where('sent', 0)
                ->join('users', 'users.id', 'send_emails.user_id')
                ->select('send_emails.to', 'send_emails.subject', 'send_emails.body', 'users.email as user_email', 'users.nombre as user_name')
                ->get();
            foreach ($sendMail as $key => $value) {
                Mail::send(new \App\Mail\SendEmail($value));
                $value['sent'] = 1;
                $value->save();
            }
        })->hourly();
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
