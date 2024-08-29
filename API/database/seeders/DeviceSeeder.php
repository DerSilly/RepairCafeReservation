<?php
// database/seeders/DeviceSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\Appointment;

class DeviceSeeder extends BaseSeeder
{

    public function run()
    {
        foreach (self::$appointments as $appointment) {
            $appointment->devices()->attach(Device::factory()->create());
        }
        self::$devices = Device::all();
    }
}
