<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthApiController extends Controller
{
    use HttpResponses;

    private AuthRepositoryInterface $AuthRepository;

    public function __construct(AuthRepositoryInterface $AuthRepository) 
    {
        $this->AuthRepository = $AuthRepository; 
    }

    public function register (Request $request) {
        return $this->AuthRepository->register($request);
    }

    public function login (Request $request) {
        return $this->AuthRepository->login($request);
    }

    public function logout () {
        return $this->AuthRepository->logout();
    }

    public function users () {
        return $this->success(new UserResource(User::all()), 'get all users', 201);
    }
}
