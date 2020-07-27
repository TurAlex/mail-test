<?php

use App\Models\Message;
use Illuminate\Database\Seeder;


class MessagesSeeder extends Seeder
{

    public const START_ID = 1;
    public const FINISH_ID = 1000;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $messages = [];


        try {
            DB::beginTransaction();
            for ($i = self::START_ID; $i < self::FINISH_ID; $i++) {
                $messages[] = [
//                'id' => $i,
                    'subject' => $faker->sentence(4),
                    'body' => $faker->text(200),
                ];
            }
            Message::insert($messages);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }


    }

}
