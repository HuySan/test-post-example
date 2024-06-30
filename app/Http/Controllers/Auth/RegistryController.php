<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegistryController extends Controller
{
    protected UserRepository $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }
    public function register(AuthRequest $request)
    {
        $user = $this->userRepository->create($request);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('user', 'token'), 201);
    }
}
