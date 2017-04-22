<?php

use Illuminate\Database\Seeder;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Meal::create([
            'title'       => 'Home Meal 1',
            'description' => 'Description 1',
            'url'         => 'https://google.com',
        ]);

        App\Meal::create([
            'title'       => 'Home Meal 2',
            'description' => 'Description 2',
            'url'         => 'https://google.com',
        ]);

        App\Meal::create([
            'title'       => 'Out Meal 1',
            'description' => 'Description 1',
            'url'         => 'https://google.com',
        ]);

        App\Meal::create([
            'title'       => 'Out Meal 2',
            'description' => 'Description 2',
            'url'         => 'https://google.com',
        ]);
    }
}
