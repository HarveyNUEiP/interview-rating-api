<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_id' => Company::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'interview_review' => fake()->sentence(),
            'rating' => fake()->numberBetween(1, 10),
            'deleted_at' => null,
            'status' => 1,
        ];
    }
}
