<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Obtener el rol de usuario para asignarlo a los usuarios creados
        $userRoleId = Role::where('rol_name', 'user')->first()->id;

        return [
            'identification' => $this->faker->unique()->numerify('##########'),
            'firstname' => $this->faker->firstName,
            'secondname' => $this->faker->firstName,
            'firstlastname' => $this->faker->lastName,
            'secondlastname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'rol_id' => $userRoleId,
            'phone1' => $this->faker->phoneNumber,
            'phone2' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
