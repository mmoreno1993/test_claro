<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Provider\en_US\PhoneNumber;
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        $date = \Carbon\Carbon::parse($this->faker->dateTimeBetween('-30 years', '-18 years'))->format('Y-m-d');
        return [
            'nombre' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'cedula' => $this->faker->numberBetween(10000000000,99999999999),
            'email_verified_at' => now(),
            'password' => '$2y$10$', // password
            'celular' => $this->faker->numberBetween(1000000000,9999999999),
            'birthdate' => $date, 
            'deleted' => false,
            'city_id' => $this->faker->numberBetween(1,10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
