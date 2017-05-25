<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Week;

class WeekTest extends TestCase
{
    use DatabaseMigrations;

    public function test_weeks_can_be_created()
    {
        $week = factory(Week::class)->create([]);
        $user = factory(User::class)->create([]);

        $user->weeks()->save($week);

        $this->assertDatabaseHas("weeks", [
            "number"  => $week->number,
            "year"    => $week->year,
            "user_id" => $user->id,
        ]);
    }
}
