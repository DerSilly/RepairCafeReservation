<?php
// database/factories/DeviceFactory.php
namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition()
    {
        return [
            'kind_product' => $this->faker->word,
            'category' => $this->faker->word,
            'brand' => $this->faker->company,
            'product_build_year' => $this->faker->year,
            'model' => $this->faker->word,
            'cause_of_fault' => $this->faker->sentence,
        ];
    }
}
