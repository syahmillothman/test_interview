<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ApiEndpointTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_login_api_endpoint()
    {
        //move this to boot event later
        $user = User::first();
        $response = $this->post('/api/v1/login', ['email' => $user->email, 'password' => 'password']);

        $response->assertStatus(200)
            ->assertJson(['data' => ['token' => true]]);
    }

    public function test_user_change_password_api_endpoint()
    {
        //move this to boot event later
        $user = User::first();
        $payload = ['current_password' => 'password', 'password' => 'password', 'password_confirmation' => 'password'];

        $response = $this->withHeaders([
            'Authorization' => $this->buildAuthorizationHeader($this->getAuthToken($user)),
        ])
            ->post('/api/v1/changepassword', $payload);

        $response->assertStatus(200)
            ->assertJson(['data' => [], 'status_code' => Response::HTTP_OK]);

    }

    public function test_user_get_profile_api_endpoint()
    {
        $user = User::first();

        $response = $this->withHeaders([
            'Authorization' => $this->buildAuthorizationHeader($this->getAuthToken($user)),
        ])
            ->get('/api/v1/me');

        $response->assertStatus(200)
            ->assertJson(['data' => ['role' => []], 'status_code' => Response::HTTP_OK]);

    }

    public function test_user_update_profile_api_endpoint()
    {
        //move this to boot event later
        $user = User::first();

        $email = 'demo@dd.com';
        $name = 'demo unit test';

        $response = $response = $this->withHeaders([
            'Authorization' => $this->buildAuthorizationHeader($this->getAuthToken($user)),
        ])
            ->json('PUT', '/api/v1/me/'.$user->id, ['email' => $email, 'name' => $name]);

        $response->assertStatus(200)
            ->assertJson(['data' => [], 'status_code' => Response::HTTP_OK]);

        //check assertion for database tables
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name'  => $name,
        ]);

    }

}
