<?php

namespace Tests\Feature;

use App\Persistence\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\BaseTestCase;

class AuthControllerTest extends BaseTestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * Test login when no input is provided
     */
    public function testLoginValidation()
    {
        $response = $this->post('api/auth/login', []);
        $data = json_decode($response->content(), true);
        $this->assetValidationError($data, 2);
        $errors = $data['errors'];
        $this->assertEquals('Email not set', $errors[0]);
        $this->assertEquals('Password not set', $errors[1]);
        $response->assertStatus(422);
    }

    public function testLoginSuccessful()
    {
        $password = "Test";
        $user = User::create([
            'first_name' => "John",
            'last_name' => "Doe",
            'email' => "john@example.com",
            'email_verified_at' => now(),
            'password' => bcrypt($password),
            'remember_token' => Str::random(10)
        ]);

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $data = json_decode($response->content(), true);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'firstName',
                'lastName',
                'email'
            ]
        ]);
        $responseData = $data['data'];
        $this->assertEquals($user->first_name, $responseData['firstName']);
        $this->assertEquals($user->last_name, $responseData['lastName']);
        $this->assertEquals($user->email, $responseData['email']);
        $this->assertEquals($user->id, $responseData['id']);
        $response->assertStatus(200);
    }

    public function testUserCantLoginWithWrongCredentials()
    {
        $user = User::factory()->make([
            'password' => bcrypt('Test')
        ]);

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => 'Testing',
        ]);

        $data = json_decode($response->content(), true);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertArrayHasKey('errorCode', $data);
        $this->assertEquals("Invalid credentials", $data['message']);
        $this->assertEquals(401, $data['statusCode']);
        $this->assertEquals('CREDENTIALS_ERROR', $data['errorCode']);
        $response->assertStatus(401);
    }

    public function testUserCanCreateAccount()
    {
        $response = $this->post('api/auth/register', [
            'firstName' => "John",
            "lastName" => "Doe",
            "email" => "doe@john.com",
            "password" => "john"
        ]);
        $data = json_decode($response->content(), true);
        $this->assertArrayHasKey('message', $data);
        $this->assertArrayHasKey('statusCode', $data);
        $this->assertEquals('User created', $data['message']);
        $this->assertEquals(201, $data['statusCode']);
        $response->assertStatus(201);
    }
}
