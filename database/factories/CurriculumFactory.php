<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Curriculum;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curriculum>
 */
class CurriculumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Curriculum::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $teacher = Teacher::inRandomOrder()->first();
    
        $now = Carbon::now();
        $time = $now->setTime(8, 0, 0);
        $randomHour = rand(8, 20);
        $time->setTime($randomHour, 0, 0);
    
        $date = Carbon::now()->addDays(rand(-20, 20));
        if ($date->isPast()) {
            $state = $this->faker->randomElement([3, 4, 5, 6, 7, 8]);
            $comment = ($state === 4) ? $this->faker->words(10, true) : null;
            $stars = ($state === 4) ? $this->faker->randomElement([1, 2, 3, 4, 5]) : null;
        } else {
            $state = $this->faker->randomElement([1, 2, 6, 7, 8]);
            $comment = null;
            $stars = null;
        }
    
        return [
            'teacher_id'    => $teacher->id,
            'student_id'    => $user->id,
            'date'          => $date->format('Y-m-d'),
            'time'          => $time->format('H:i:s'),
            'state_id'      => $state,
            'price'         => $teacher->price,
            'comment'       => $comment,
            'stars'         => $stars,
            'created_at'    => Carbon::now()->subDays(rand(1, 30)),
            'updated_at'    => Carbon::now(),
        ];
    }
}
