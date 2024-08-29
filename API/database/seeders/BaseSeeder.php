<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;


abstract class BaseSeeder extends Seeder {
    protected static $users;
    protected static $appointments;
    protected static $devices;
}
