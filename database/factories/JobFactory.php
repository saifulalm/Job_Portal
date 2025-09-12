<?php

namespace Database\Factories;

use App\Models\CompanyProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // We'll provide the company_profile_id when we call this from the seeder
            'company_profile_id' => CompanyProfile::factory(),
            'title' => fake()->jobTitle(),
            'description' => fake()->paragraphs(5, true), // 5 paragraphs of text
            'location' => fake()->city() . ', ' . fake()->country(),
            'job_type' => fake()->randomElement(['Full-time', 'Part-time', 'Contract', 'Internship']),
            'salary' => 'IDR ' . fake()->numberBetween(8, 25) . ',000,000',
        ];
    }
}
