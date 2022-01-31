<?php

namespace App\Http\Controllers;

use App\Business\DTO\UserDTO;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Business\Services\AuthService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class AuthController extends Controller
{
    use ResponseTrait;

    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * Constructor method
     *
     * @param AuthService $service
     */
    public function __construct(AuthService $service)
    {
        $this->authService = $service;
    }

    /**
     * Login user
     * @param AuthRequest $request
     * @return UserResource|JsonResponse
     */
    public function login(AuthRequest $request)
    {
        $data = $request->validated();

        if (!Auth::attempt($data)) {
            return $this->responseUnauthorized(
                'Invalid credentials',
                [],
                config('system.error_codes.CREDENTIALS')
            );
        }

        $user = auth()->user();

        if (empty($user->email_verified_at)) {
            return $this->responseUnauthorized(
                'Email not verified.',
                [],
                config('system.error_codes.EMAIL_UNVERIFIED')
            );
        }

        $request->session()->regenerate();

        return new UserResource($user);
    }


    /**
     * Create mew user account
     * @param UserRequest $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function register(UserRequest $request): JsonResponse
    {
        $data =  $request->validated();
        //create user
        $this->authService->createUser(new UserDTO([
            'email' => $data['email'],
            'password' => $data['password'],
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            ]));
        return $this->responseCreated("User created");
    }


    /**
     * Logout user
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $this->responseOk("User logged out");
    }
}
