<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\RepairDetail;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Repair Admin',
            'email' => 'admin@repaircafe.com',
            'password' => bcrypt('password'),
        ]);

        User::factory(9)->create();

        self::$users = User::all();


        $this->call([
            LocationSeeder::class,
            RoleSeeder::class,
            AppointmentSeeder::class,
            DeviceSeeder::class,
            RepairDetailSeeder::class,
            #AssignmentSeeders::class,
        ]);

        $roles = \App\Models\Role::all()->pluck('id');
        foreach (self::$users as $user) {
            $randomRoles = $roles->random(random_int(1,3));
            $user->roles()->attach($randomRoles);
        }
    }
}
