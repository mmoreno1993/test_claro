<?php

namespace Database\Factories;

use App\Models\State;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StateFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected static $state = array(
        'Lima',
        'Medellin',
        'Santiago',
        'Barcelona',
        'Miami',
        'Buenos Aires',
        'Puno',
        'Cusco',
        'Arequipa',
        'Trujillo',
        'Ferreñafe',
        'Guadalajara',
    );
    protected $model = State::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_id' => $this->faker->numberBetween(1,50),
            'nombre' => $this->faker->randomElement(static::$state),
        ];
    }
}
