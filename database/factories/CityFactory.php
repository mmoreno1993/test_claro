<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected static $city = array(
        'ALima',
        'BMedellin',
        'CSantiago',
        'DBarcelona',
        'EMiami',
        'FBuenos Aires',
        'HPuno',
        'ICusco',
        'JArequipa',
        'KTrujillo',
        'LFerreñafe',
        'MGuadalajara',
    );
    protected $model = City::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'state_id' => $this->faker->numberBetween(1,50),
            'nombre' => $this->faker->randomElement(static::$city),
        ];
    }
}
