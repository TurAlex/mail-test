<?php

namespace App\Jobs;

use App\Mail\SendUserMessage;
use App\Models\MessageSchedule;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendTimezoneMessagesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $timezone;
    /**
     * @var string
     */
    public $time;


    /**
     * Create a new job instance.
     *
     * @param $timezone
     * @param $time
     */
    public function __construct($timezone, $time)
    {
        $this->timezone = $timezone;
        $this->time = $time;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $schedules = MessageSchedule::where('time', $this->time)
            ->with([
                'message',
                'users' => function (BelongsToMany $relation){
                    return $relation->where('timezone', $this->timezone);
                },
            ])
            ->whereHas('users', function(Builder $query){
                return $query->where('timezone', $this->timezone);

            })
            ->get();
        $schedules->each(function (MessageSchedule $schedule){
            $message = new SendUserMessage($schedule->message->subject, $schedule->message->body);
            $schedule->users->each(function (User $user) use ($message){
//                Mail::to($user->email)->send($message);
            });
        });

    }
}
