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

        $state = $this->faker->randomElement([1, 2, 3, 4]);
        if ($state === 3) {
            $comment = $this->faker->words(10, true);
        } else {
            $comment = null;
        }

        $counter = 0;
        $maxAttempts = 100;
        $availableDays = collect(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
            ->filter(function ($day) use ($teacher) {
                return $teacher->{$day} === 1;
            })
            ->toArray();

        $date = Carbon::now()->addDays(rand(0, 20));
        while (!in_array(strtolower($date->englishDayOfWeek), $availableDays)) {
            $date->addDay();
        }

        return [
            'teacher'       => $teacher->id,
            'student'       => $user->id,
            'date'          => $date->format('Y-m-d'),
            'time'          => $time->format('H:i:s'),
            'state'         => $state,
            'price'         => $teacher->price,
            'comment'       => $comment,
            'created_at'    => Carbon::now()->subDays(rand(1, 30)),
            'updated_at'    => Carbon::now(),
        ];
    }
}
