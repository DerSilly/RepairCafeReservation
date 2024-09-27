<?php
// database/factories/LocationFactory.php
namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Repaircafe A', 'Repaircafe B', 'Repaircafe C']),
            'address' => $this->faker->address,
            'phone_number' => $this->faker->phoneNumber,
            'manager_id' => \App\Models\User::whereHas('roles', function($query) {
                $query->where('name', 'Admin');
            })->first()->id,
        ];
    }
}
