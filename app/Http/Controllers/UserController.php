<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserController extends Controller
{
    public function createToken($user)
    {
        if ($user->username == 'admin') {
            $token = $user->createToken('admin-token')->plainTextToken;
        } else {
            $token = $user->createToken('user-token', ['document:*', 'group:*'])->plainTextToken;
        }

        return $token;
    }

    public function register(UserRegisterRequest $request): UserResource
    {
        $data = $request->validated();

        if (User::where('username', $data['username'])->count() == 1) {
            // user allready exist
            throw new HttpResponseException(response([
                "errors" => [
                    "username" => [
                        "Username allready exist"
                    ]
                ]
            ], 400));
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        $token = $this->createToken($user);

        return (new UserResource($user))->additional(["token" => $token]);
    }

    public function login(UserLoginRequest $request): UserResource
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw new HttpResponseException(response([
                "errors" => [
                    "message" => [
                        "Wrong username and password combination"
                    ]
                ]
            ], 400));
        }

        $token = $this->createToken($user);

        return (new UserResource($user))->additional(["token" => $token]);
    }
}
