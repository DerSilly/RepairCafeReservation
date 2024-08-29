<?php
// database/seeders/RoleSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Admin',
                'description' => 'Administrator role',
            ],
            [
                'name' => 'Staff',
                'description' => 'Staff role',
            ],
            [
                'name' => 'Guest',
                'description' => 'Guest role',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
