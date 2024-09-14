<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Location;
use App\Models\User;

class AppointmentSeeder extends BaseSeeder
{
    public function run()
    {
        foreach (self::$users as $user) {
            Appointment::factory()->
                create(['guest_id' => $user->id, 'location_id' => Location::pluck('id')->random()]);
        }
        self::$appointments = Appointment::all();
    }
}
