<?php

namespace Tests\Unit;

use App\Business\DTO\UserDTO;
use App\Business\Services\AuthService;
use App\Persistence\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    protected AuthService $authService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->authService = app(AuthService::class);
    }

    /**
     * Test user account creation
     * @throws UnknownProperties
     */
    public function testAccountCreation()
    {
        $data = new UserDTO([
            'email' => "test@example.com",
            'password' => "test",
            'firstName' => "John",
            'lastName' => "Doe"
        ]);
        $user = $this->authService->createUser($data);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals(1, $user->id);
        $this->assertEquals("John", $user->first_name);
        $this->assertEquals("Doe", $user->last_name);
        $this->assertEquals("test@example.com", $user->email);
        $this->assertIsString($user->password);
    }
}
