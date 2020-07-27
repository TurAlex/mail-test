<?php

use App\Models\MessageSchedule;
use Illuminate\Database\Seeder;


class MessageScheduleUserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $messageScheduleUser = [];
        $totalQuantity = 0;


        try {
            DB::beginTransaction();
            MessageSchedule::each(function (MessageSchedule $messageSchedule) use (&$messageScheduleUser, &$totalQuantity, $faker) {
                $usersQuantity = $faker->numberBetween(1, 100);
                $totalQuantity += $usersQuantity;
                for ($i = 1; $i <= $usersQuantity; $i++) {
                    $messageScheduleUser[] = [
                        'message_schedule_id' => $messageSchedule->id,
                        'user_id' => $faker->numberBetween(UsersSeeder::START_ID, UsersSeeder::FINISH_ID),
                    ];
                }

                if ($totalQuantity > 5000) {
                    DB::table('message_schedule_user')->insert(self::onlyUnique($messageScheduleUser));
                    $totalQuantity = 0;
                    $messageScheduleUser = [];
                    dump('schedule id :' . $messageSchedule->id);
                }

            }, 1000);
            DB::table('message_schedule_user')->insert(self::onlyUnique($messageScheduleUser));
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }


    }

    /**
     * @param array $arr
     * @return array
     */
    private function onlyUnique(array $arr): array
    {
        return array_intersect_key($arr, array_unique(
            array_map('serialize', $arr)
        ));
    }

}
