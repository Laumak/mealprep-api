<?php

use Illuminate\Database\Seeder;

class PlannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Week::create([
            'number' => 15,
            'year'   => 2017
        ]);

        App\Week::create([
            'number' => 16,
            'year'   => 2017
        ]);

        App\Week::create([
            'number' => 17,
            'year'   => 2017
        ]);

        $weeks = App\Week::all();

        foreach($weeks as $week) {
            $week->days()->create([
                'name' => 'monday'
            ]);
            $week->days()->create([
                'name' => 'tuesday'
            ]);
            $week->days()->create([
                'name' => 'wednesday'
            ]);
            $week->days()->create([
                'name' => 'thursday'
            ]);
            $week->days()->create([
                'name' => 'friday'
            ]);
            $week->days()->create([
                'name' => 'saturday'
            ]);
            $week->days()->create([
                'name' => 'sunday'
            ]);
        }
    }
}
