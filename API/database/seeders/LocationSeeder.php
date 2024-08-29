<?php
// database/seeders/LocationSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    public function run()
    {
        Location::create([
            'name' => 'Repaircafe A',
            'address' => 'Fakestreet 123',
            'phone_number' => '123-456-7890',
            'email' => 'admin@repaircafea.com']);
    }
}
