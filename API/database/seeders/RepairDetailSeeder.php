<?php
// database/seeders/RepairDetailSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RepairDetail;
use App\Models\Device;
use App\Models\User;

class RepairDetailSeeder extends BaseSeeder
{

    public function run()
    {
        foreach (self::$devices as $device) {
           RepairDetail::factory()->
            create(['device_id' => $device->id, 'repairer_id' => User::pluck('id')->random()]);
        }
    }
}
