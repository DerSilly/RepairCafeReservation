<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use App\Models\Role;
use Database\Seeders\DatabaseSeeder;

abstract class TestCase extends BaseTestCase
{
    protected User $adminUser;
    protected User $guestUser;

    protected string $adminToken;
    protected string $guestToken;

    protected function setUp(): void
    {

        parent::setUp();

        $this->withoutExceptionHandling();
        // Überschreibe die Login-Route für Tests
        config(['auth.login_url' => '/api/login']);

        $this->adminUser = User::factory()->create(["password" => bcrypt("password"), "email" => "testadmin@example.com"]);
        Role::factory()->createMany([
            ["name" => "admin"],
            ["name" => "staff"],
            ["name" => "guest"]
        ]);
        $this->adminUser->roles()->attach([1,2,3]);
        $this->adminToken = $this->adminUser->createToken('test-token',['*'])->plainTextToken;

        $this->guestUser = User::factory()->create(["password" => bcrypt("password"), "email" => "testguest@example.com"]);
        $this->guestUser->roles()->attach(3);
        $this->guestToken = $this->guestUser->createToken('test-token',['guest'])->plainTextToken;
    }


    protected function tearDown(): void
    {
        return;
        $this->adminUser->roles()->detach();
        $this->adminUser->tokens()->delete();
        $this->adminUser->delete();
        $this->guestUser->roles()->detach();
        $this->guestUser->tokens()->delete();
        $this->guestUser->delete();
        parent::tearDown();
    }
}
