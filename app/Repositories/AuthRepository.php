<?php

namespace App\Repositories;

use App\Http\Resources\UserResource;
use App\Interfaces\AuthRepositoryInterface;
use App\Mail\SubscriberMail;
use App\Models\Subscriber;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthRepository implements AuthRepositoryInterface
{
    use HttpResponses;

    public function register ($request) {
        $validator = Validator::make($request->all(), [
            'profile' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20480'],
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        if ( $validator->fails() ) {
            return $this->error(null, $validator->errors()->first(), 422);
        }
        try {
            if ( Request::ajax() ){
                $user = new User();
                if ($request->hasFile('profile')) {
                    $file = $request->file('profile');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/profiles/', $filename);
                    $user->profile = $filename;
                }
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $request->password;
                $user->save();
                auth()->login($user);
                return $this->success($user, 'Register Successfully!', 201);
            }else {
                $user = new User();
                if ($request->hasFile('profile')) {
                    $file = $request->file('profile');
                    $extension = $file->getClientOriginalExtension();
                    $filename = time() . '.' . $extension;
                    $file->move('uploads/profiles/', $filename);
                    $user->profile = $filename;
                }
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = $request->password;
                $user->save();
                $token = $user->createToken('personal-access-token')->plainTextToken;
                $user['access_token'] = $token;
                $user['token_type'] = 'Bearer';
                return $this->success(new UserResource($user), 'Register Successfully!', 201);
            }
        } catch (\Throwable $th) {
            $this->error(null, 'Server Error!', 500);
        }
    }

    public function login ($request) {
       $validator = Validator::make($request->all(), [
           'email' => ['required', 'email', Rule::exists('users', 'email')],
           'password' => ['required', 'min:6']
        ]);

        if ( $validator->fails() ) {
            return $this->error(null, $validator->errors()->first(), 422);
        }
        $status = auth()->attempt(['email' => $request->email, 'password' => $request->password]);
        if ( !$status ) {
            return $this->error(null, 'Wrong password!', 422);
        }
        if ( Request::ajax() ) {
            if ($status) {
                return $this->success(null, 'Login Successfully!', 200);
            }else {
                return $this->error(null, 'Server Error', 500);
            }
        }else {
            try {
                $user = $request->user();
                $token = $user->createToken('personal-access-token')->plainTextToken;
                $user['access_token'] = $token;
                $user['token_type'] = 'Bearer';
                return $this->success(new UserResource($user), 'Login Successfully!', 200);
            } catch (\Throwable $th) {
                return $this->error(null, 'Server Error!', 500);
            }
        }
    }

    public function logout () {
        try {
            if ( Request::ajax() ) {
                auth()->logout();
            }else{
                auth()->user()->tokens()->delete();
            }
            return $this->success(null, 'Logout Successfully!', 201);
        } catch (\Throwable $th) {
            $this->error(null, 'Server Error!', 500);
        }
    }

    public function subscribe ($request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', Rule::unique('subscribers', 'email')]
        ]);

        if($validator->fails()){
            return $this->error(null, $validator->messages()->first(), 422);
        }

        try {
            $subscriber = new Subscriber();
            $subscriber->name = $request->name;
            $subscriber->email = $request->email;
           if ($subscriber->save()) {
               Mail::to($request->email)->queue(new SubscriberMail($request->name));
           }
            return $this->success($subscriber, 'Register successfully!', 201);
        } catch (\Throwable $th) {
            return $this->error(null, 'Server Error!', 500);
        }
    }
}
