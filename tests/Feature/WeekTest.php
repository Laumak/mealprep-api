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

    public function test_week_has_7_week_days_created()
    {
        $week = factory(Week::class)->create([]);

        $days = $week->days()->get();

        $this->assertCount(7, $days);
    }
}
