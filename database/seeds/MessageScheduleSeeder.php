<?php

use App\Models\MessageSchedule ;
use Illuminate\Database\Seeder;


class MessageScheduleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();


        $messageSchedule = [];


        $time = now()->startOfDay();

        $finish = $time->copy()->endOfDay();

        $totalQuantity = 0;

        try {
            DB::beginTransaction();
            while ($time->lt($finish)) {
                $messagesQuantity = $faker->numberBetween(1, 150);
                $totalQuantity += $messagesQuantity;
                $messageTime = $time->format('H:i');
                for ($i = 1; $i <= $messagesQuantity; $i++) {
                    $messageSchedule[] = [
                        'time' => $messageTime,
                        'message_id' => $faker->numberBetween(MessagesSeeder::START_ID, MessagesSeeder::FINISH_ID),
                    ];
                }

                if ($totalQuantity > 10000) {
                    MessageSchedule::insert($messageSchedule);
                    $totalQuantity = 0;
                    $messageSchedule = [];
                    dump($messageTime);
                }
                $time->addMinute();
            }
            MessageSchedule::insert($messageSchedule);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

}
