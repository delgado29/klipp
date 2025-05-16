<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $payload = [
                'iss' => "laravel-jwt",
                'sub' => auth()->user()->id,
                'iat' => time(),
                'exp' => time() + 60 * 60,
            ];

            $jwt = $this->generateJWT($payload);

            return response()->json([
                'user' => auth()->user()->load('role'),
                'message' => 'Login successful',
                'token' => $jwt
            ]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout()
    {
        return response()->json(['message' => 'Logout simulated — token discarded on client side.']);
    }
    public function register(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Generate a new token for the user
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    private function generateJWT(array $payload)
    {
        $header = base64_encode(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
        $body = base64_encode(json_encode($payload));
        $secret = env('JWT_SECRET', 'mi_clave_secreta');

        $signature = hash_hmac('sha256', "$header.$body", $secret, true);
        $signature = base64_encode($signature);

        return "$header.$body.$signature";
    }

}
