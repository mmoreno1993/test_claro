<?php

namespace Database\Factories;

use App\Models\SendEmail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class SendEmailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SendEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'user_id' => $this->faker->numberBetween(1,50),
            'subject' => $this->faker->name(),
            'to' => $this->faker->email(),
            'body' => $this->faker->sentence(150),
            'sent' => $this->faker->numberBetween(0,1),
        ];
    }
}
