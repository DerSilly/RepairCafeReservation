<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    use ApiResponses, HasApiTokens;
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->roles()->attach(Role::where('name','Guest')->first()->id);

        return response()->json($user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $authToken = $user->createToken('auth-token', $user->roles()->pluck('name')->toArray())->plainTextToken;

        return $this->successResponse([
            'access_token' => $authToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 'Logged in successfully');
    }

    public function logout(Request $request)
    {
        Log::info('API Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'headers' => $request->headers->all(),
            'body' => $request->all()
        ]);
        $request->user()->tokens()->delete();
        return $this->successResponse((object) null, 'Logged out successfully', 204);
    }

}
