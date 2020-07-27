<?php

use App\Models\User;
use Illuminate\Database\Seeder;


class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public const START_ID = 1;
    public const FINISH_ID = 10000;

    public function run()
    {
        $faker = Faker\Factory::create();
        $timeZones = DateTimeZone::listIdentifiers();
        $timeZonesMaxIndex = count($timeZones) - 1;
        $users = [];
        $now = now();
        try {
            DB::beginTransaction();
            for ($i = self::START_ID; $i <= self::FINISH_ID; $i++) {
                $users[] = [
//                    'id' => $i,
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'email_verified_at' => $now,
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'remember_token' => Str::random(10),
                    'timezone' => $timeZones[$faker->biasedNumberBetween(0, $timeZonesMaxIndex)],
                ];

                if ($i % 10000 == 0) {
                    User::insert($users);
                    $users = [];
                    dump('users seeded:' . $i);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }
}
