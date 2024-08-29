<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Location;
use App\Models\Device;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition()
    {
        return [
            'start_time' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'end_time' => $this->faker->dateTimeBetween('start_time', '+20 minutes'),
            'location_id' => Location::factory()->create(),
            'user_id' => User::factory()->create(),
            'note' => $this->faker->optional()->text,
        ];
    }
}
