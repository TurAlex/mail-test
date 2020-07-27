<?php

namespace App\Console\Commands;

use App\Jobs\SendTimezoneMessagesJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scheduled-messages:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send messages to users by scheduled time';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        //select all available timezones -- maybe better way to add dictionary to db or a static data
        $timeZones = User::groupBy('timezone')->select('timezone')->pluck('timezone');
        $currentTime = now()->format('H:i');

        foreach ($timeZones as $timeZone) {
            $time = Carbon::parse($currentTime, $timeZones)->format('H:i');
            dispatch(new SendTimezoneMessagesJob($timeZone, $time));
        }
    }
}