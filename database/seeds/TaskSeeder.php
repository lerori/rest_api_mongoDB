<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();
        $cuantos= Task::all()->count();

        for ($i=0; $i<50; $i++)
        {
            Task::create(
                [
                    'title'=>$faker->word(),
                    'description'=>$faker->word(),
                    'due_date'=>$faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now', $timezone = null),
                    'completed'=>$faker->numberBetween(0,1)
                ]
            );
        }
    }
}
