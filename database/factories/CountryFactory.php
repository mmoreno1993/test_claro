<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected static $country = array(
        'Perú',
        'Colombia',
        'España',
        'Italia',
        'Francia',
        'Venezuela',
        'Argentina',
        'Canada',
        'Estados Unidos',
        'Ecuador',
        'Guatemala',
        'El Salvador',
    );
    protected $model = Country::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nombre' => $this->faker->randomElement(static::$country),
        ];
    }
}
