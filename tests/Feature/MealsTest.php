<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Meal;

class MealsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_meals_can_be_created()
    {
        $meal = factory(Meal::class)->create([]);

        $this->assertDatabaseHas("meals", [
            "id"    => $meal->id,
            "title" => $meal->title,
        ]);
    }
}
