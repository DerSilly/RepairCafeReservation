<?php
// database/factories/RepairDetailFactory.php
namespace Database\Factories;

use App\Models\RepairDetail;
use App\Models\User;
use App\Models\Device;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RepairDetailFactory extends Factory
{
    protected $model = RepairDetail::class;

    public function definition()
    {
        return [
            'repairer_id' => User::factory()->create(),
            'device_id' => Device::factory()->create(),
            'repair_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'fault' => $this->faker->sentence,
            'solution' => $this->faker->sentence,
            'repairability' => $this->faker->numberBetween(1, 10),
            'repair_failed_reason' => $this->faker->optional()->sentence,
            'advice' => $this->faker->optional()->text,
            'repair_source' => $this->faker->optional()->url,
            'hint' => $this->faker->optional()->text,
        ];
    }
}
