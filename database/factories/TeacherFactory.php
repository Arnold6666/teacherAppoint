<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Teacher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Teacher>
 */
class TeacherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Teacher::class;

    public function definition(): array
    {
        // $imagePath = $this->faker->image(storage_path('app/public/teachers'), 300, 300, null, false);
        // // die($imagePath);
        // $imageFile = new File(storage_path('app/public/teachers/' . $imagePath));

        // $imageFilename = $imageFile->getFilename();
        // $imageStoragePath = '/storage/app/public/teachers/' . $imageFilename;
        // Storage::disk('public')->put($imageStoragePath, file_get_contents(storage_path('app/public/teachers/' . $imagePath)));
        $imagePath = $this->faker->image(storage_path('app/public/teachers'), 300, 300, null, false);
        $imageFilename = basename($imagePath);
        $imageStoragePath = 'public/teachers/' . $imageFilename;
        Storage::disk('local')->move($imagePath, $imageStoragePath);

        return [
            'name'  => fake()->name(),
            'image' => $imageStoragePath,
            'intro' => fake()->words(20, true),
            'country'=> $this->faker->randomElement(["US", "UK", "TW", "HK", "IN"]),
            'email' => fake()->unique()->safeEmail(),
            'monday' => $this->faker->randomElement([0, 1]),
            'tuesday' => $this->faker->randomElement([0, 1]),
            'wednesday' => $this->faker->randomElement([0, 1]),
            'thursday' => $this->faker->randomElement([0, 1]),
            'friday' => $this->faker->randomElement([0, 1]),
            'saturday' => $this->faker->randomElement([0, 1]),
            'sunday' => $this->faker->randomElement([0, 1]),
            'price' => $this->faker->randomElement([500, 600, 700, 800, 900, 1000]),
            'stars' => $this->faker->randomElement([3, 4, 5]),
            'comments' => $this->faker->numberBetween(10, 200),
            'created_at'    => Carbon::now()->subDays(rand(1, 30)),
            'updated_at'    => Carbon::now(),
        ];
    }
}
