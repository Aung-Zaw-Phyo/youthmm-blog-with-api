<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
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

    public function subscribe (Request $request) {
        return $this->AuthRepository->subscribe($request);
    }

    //    profile

    public function updateProfile (Request $request) {
        $validator = Validator::make($request->all(), [
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:20480'],
        ]);

        if ($validator->fails()) {
            return $this->error(null, $validator->messages()->first(), 422);
        }

        try {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/profiles/', $filename);
            $user = auth()->user();
            $user->profile = $filename;
            $user->update();
            return $this->success($user->profile, 'Profile updated successfully!', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

    public  function updateName (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->error(null, $validator->messages()->first(), 422);
        }

        try {
            $user = auth()->user();
            $user->name = $request->name;
            $user->update();
            return $this->success($user->name, 'Name updated successfully!', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }

    }


    public function updateEmail (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => ['required', Rule::unique('users', 'email')],
        ]);

        if ($validator->fails()) {
            return $this->error(null, $validator->messages()->first(), 422);
        }

        try {
            $user = auth()->user();
            $user->email = $request->email;
            $user->update();
            return $this->success($user->email, 'Email updated successfully!', 201);
        }catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }

}
