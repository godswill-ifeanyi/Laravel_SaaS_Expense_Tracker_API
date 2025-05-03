<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponseTrait;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::defaults()],
            'company_id' => 'required|exists:companies,id'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company_id,
            'role' => 'Admin',
            'password' => $request->password,
            //'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token of '.$user->name)->plainTextToken;

        return $this->success([
            'admin' => new UserResource($user)
        ], 'Admin registered successfully.',201);
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only(['email','password']))) {
            return $this->error('Credentials do not match', 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token of '.$user->name)->plainTextToken;

        return $this->success([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Login Successful.');
    }

    public function logout() {
        Auth::user()->currentAccessToken()->delete();

        return $this->success(null, 'Successfully logged out user.');
    }
}
