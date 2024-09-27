<?php

namespace Database\Seeders;

use App\Models\Device;
use App\Models\RepairDetail;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends BaseSeeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminUser = User::factory()->create([
            'name' => 'Repair Admin',
            'email' => 'admin@repaircafe.com',
            'password' => bcrypt('password'),
        ]);
        $this->call(RoleSeeder::class);
        $adminUser->roles()->attach([1,2]);

        $this->call(LocationSeeder::class);

        User::factory(9)->create();

        self::$users = User::all()->except($adminUser->id);

        $roles = \App\Models\Role::all()->pluck('id');
        foreach (self::$users as $user) {
            $randomRoles = $roles->random(random_int(1,3));
            $user->roles()->attach($randomRoles);
        }

        self::$guestUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Guest');
        })->get();

        $this->call([
            AppointmentSeeder::class,
            DeviceSeeder::class,
            RepairDetailSeeder::class]);
    }
}
