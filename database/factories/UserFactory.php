<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        $role = $this->faker->randomElement(['candidate','enterprise']);

        return [
            'role' => $role,
            'name' => $this->faker->lastName,
            'firstname' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'phone' => $this->faker->phoneNumber,
            'city' => $this->faker->city,

            // candidats
            'profile_photo'  => $role === 'candidate' ? $this->faker->imageUrl(100, 100, 'people') : null,
            'profile_banner' => $role === 'candidate' ? $this->faker->imageUrl(600, 200, 'business') : null,
            'cv'             => $role === 'candidate' ? 'cv/' . $this->faker->uuid . '.pdf' : null,
            'about'          => $role === 'candidate' ? $this->faker->paragraph() : null,
            'expected_salary'=> $role === 'candidate' ? $this->faker->numberBetween(30000, 100000) : null,

            // entreprises
            'company_name' => $role === 'enterprise' ? $this->faker->company : null,
            'siret' => $role === 'enterprise' ? $this->faker->numerify('#############') : null,
            'recruitment_description' => $role === 'enterprise' ? $this->faker->paragraph() : null,
            'team_description' => $role === 'enterprise' ? $this->faker->paragraph() : null,
            'description' => $role === 'enterprise' ? $this->faker->paragraph() : null,
            'logo' => $role === 'enterprise' ? $this->faker->imageUrl(100, 100, 'business') : null,
            'website_url' => $role === 'enterprise' ? $this->faker->url : null,
            'is_verified' => $this->faker->boolean(50),
            'is_admin' => $this->faker->boolean(10),
        ];
    }
}
