<?php

namespace Tests\Feature;

use App\Persistence\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\BaseTestCase;

class AuthControllerTest extends BaseTestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    /**
     * Test login when no input is provided
     */
    public function testLoginValidationNoEmail()
    {
        $response = $this->post('auth/login', [
            'password' => 'Test'
        ]);
        $this->handleSingleFieldValidation($response, 'Email not set');
    }

    public function testLoginValidationNoPassword()
    {
        $response = $this->post('auth/login', [
            'email' => 'Test@example.com'
        ]);
        $this->handleSingleFieldValidation($response, 'Password not set');
    }

    public function testLoginSuccessful()
    {
        $password = "Test";

        $user = User::factory()->create([
            'password' => bcrypt($password)
        ]);

        $response = $this->post('auth/login', [
            'email' => $user->email,
            'password' => $password,
        ], [
            'Accept' => 'application/json'
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
        $user = User::factory()->create([
            'password' => bcrypt('Test')
        ]);

        $response = $this->post('auth/login', [
            'email' => $user->email,
            'password' => 'TestingMe',
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
        $response = $this->post('auth/register', [
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

    public function testRegistrationValidateNoFirstName()
    {
        $response = $this->post('auth/register', [
            "lastName" => "Doe",
            "email" => "doe@john.com",
            "password" => "john"
        ]);

        $this->handleSingleFieldValidation($response, 'First name is required');
    }

    public function testRegistrationValidateFirstNameMinCharacters()
    {
        $response = $this->post('auth/register', [
            "firstName" => "D",
            "lastName" => "Doe",
            "email" => "doe@john.com",
            "password" => "john"
        ]);
        $this->handleSingleFieldValidation($response, 'First must be a minimum of 2 characters');
    }
    public function testRegistrationValidateNoLastName()
    {
        $response = $this->post('auth/register', [
            "firstName" => "John",
            "email" => "doe@john.com",
            "password" => "john"
        ]);
        $this->handleSingleFieldValidation($response, 'Last name is required');
    }

    public function testRegistrationValidateLastNameMinCharacters()
    {
        $response = $this->post('auth/register', [
            "firstName" => "John",
            "lastName" => "D",
            "email" => "doe@john.com",
            "password" => "john"
        ]);
        $this->handleSingleFieldValidation($response, 'Last must be a minimum of 2 characters');
    }

    public function testRegistrationValidateNoEmailField()
    {
        $response = $this->post('auth/register', [
            "firstName" => "John",
            "lastName" => "Doe",
            "password" => "john"
        ]);
        $this->handleSingleFieldValidation($response, 'Email field is required');
    }

    public function testRegistrationValidateWrongEmailFormat()
    {

        $response = $this->post('auth/register', [
            "firstName" => "John",
            "lastName" => "Doe",
            "password" => "john",
            "email" => "doe@",
        ]);
        $this->handleSingleFieldValidation($response, 'A valid email address is required');
    }

    public function testRegistrationValidateEmailExists()
    {
        $user = User::factory()->create([
            'email' => "john@example.com",
        ]);

        $response = $this->post('auth/register', [
            "firstName" => "John",
            "lastName" => "Doe",
            "password" => "john",
            "email" => $user->email,
        ]);
        $this->handleSingleFieldValidation($response, 'The email has already been taken.');
    }

    public function testRegistrationValidateNoPasswordField()
    {
        $response = $this->post('auth/register', [
            "firstName" => "John",
            "lastName" => "Doe",
            "email" => "john@example.com",
        ]);
        $this->handleSingleFieldValidation($response, 'Password is required');
    }
}
