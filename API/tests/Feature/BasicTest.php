<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Concerns\TestDatabases;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Session;
use App\Models\Location;
use Illuminate\Support\Facades\Log;
use DateInterval;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\DatabaseSeeder;

class BasicTest extends TestCase
{
    use WithFaker, RefreshDatabase, TestDatabases;

    public function test_the_application_returns_a_successful_response(): void
    {
        Sanctum::actingAs($this->guestUser);
        $response = $this->getJson('/api/user');
        $response->assertStatus(200);
        $responseData = $response->json('user');
        $this->assertEquals($this->guestUser->name, $responseData['name']);
    }

/*    public function test_the_application_returns_a_successful_response_for_admin_user(): void
    {
        Sanctum::actingAs($this->adminUser);
        $response = $this->getJson('/api/user');
        $response->assertStatus(200);
        $responseData = $response->json('user');
        $this->assertEquals($this->adminUser->name, $responseData['name']);
    }

    public function test_the_application_allows_appointmentupdates_only_for_admins(): void
    {
        Sanctum::actingAs($this->guestUser, ['guest']);
        $response = $this->putJson('/api/appointments/1', [
            'staff_id' => '3',
            'note' => 'This is a test',
        ]);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('appointments', [
            'staff_id' => '3',
            'note' => 'This is a test',
        ]);

        Sanctum::actingAs(User::factory()->create(),['*']);

        $response = $this->putJson('/api/appointments/1', [
            'staff_id' => '2',
            'note' => 'This is a test',
        ]);
        $response->assertOK();

        $this->assertDatabaseHas('appointments', [
            'staff_id' => '2',
            'note' => 'This is a test',
        ]);
    }

    public function test_the_application_allows_appointment_creation_for_guests(): void
    {
        Sanctum::actingAs($this->guestUser, ['guest']);
        $startTime =$this->faker->dateTimeBetween('+1 minute', '+1 month');

        $response = $this->postJson('/api/appointments', [
            'start_time' => $startTime->format('Y-m-d H:i:s'),
            'end_time' => $this->faker->dateTimeBetween($startTime->add(new DateInterval('PT1M')), $startTime->add(new DateInterval('PT20M')))->format('Y-m-d H:i:s'),
            'location_id' => Location::factory()->create()->id,
            'note' => $this->faker->optional()->text,
            'kind_product' => $this->faker->word,
            'category' => $this->faker->word,
            'brand' => $this->faker->word,
            'product_build_year' => rand(1900, date('Y')),
            'model' => $this->faker->word,
            'cause_of_fault' => $this->faker->sentence,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('appointments', [
            'staff_id' => '1',
            'note' => 'New appointment test',
        ]);
    }

    public function test_the_application_returns_a_not_found_response_for_invalid_route(): void
    {
        $this->withExceptionHandling();
        Sanctum::actingAs($this->guestUser);
        $response = $this->getJson('/api/non-existent-route');

        $response->assertStatus(404);
    }

    public function test_the_application_returns_an_unauthorized_response_if_user_not_logged_in(): void
    {
        $this->withExceptionHandling();
        $response = $this->postJson(
            '/api/login',
            [
                "email" => $this->adminUser->email,
                "password" => "password",
            ]
        );
        $response->assertOk();
        $this->adminToken = $response->json('data')['access_token'];
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->adminToken,
        ])->actingAs($this->adminUser)->getJson('/api/user');
        $response->assertStatus(200);
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->adminToken,
        ])->actingAs($this->adminUser)->postJson('/api/logout');
        $response->assertOk();
        $this->adminUser->tokens()->delete();
        $this->flushSession();
        $this->flushHeaders();
        Session::flush();
        Session::invalidate();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer invalid_token',
        ])->postJson('/api/logout');

        $response->assertHeaderMissing('Authorization');
        $response = $this->actingAs($this->adminUser)->getJson('/api/user');
        $response->assertHeaderMissing('Authorization');
        //$response->assertUnauthorized();
    }*/
}
