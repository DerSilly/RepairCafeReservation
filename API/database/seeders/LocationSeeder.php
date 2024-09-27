<?php
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
            'manager_id' => \App\Models\User::whereHas('roles', function($query) {
                $query->where('name', 'Admin');
            })->first()->id]);
    }
}
