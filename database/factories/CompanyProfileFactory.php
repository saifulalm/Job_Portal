<?php

namespace Database\Factories;

use App\Models\CompanyProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CompanyProfile>
 */
class CompanyProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Create a new user with the 'company' role for each profile
            'user_id' => User::factory()->create(['role' => 'company'])->id,
            'company_name' => fake()->company(),
            'website' => 'https://' . fake()->domainName(),
            'description' => fake()->paragraph(3),
        ];
    }
}
