<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use function response;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        try {
            Validator::make($request->only('name', 'email', 'password'), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&#]/'],
            ])->validate();

            $user = User::create([
                'name' => $request["name"],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            return response()->json(['user' => $user], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            $token = Auth::user()->createToken(
                'auth_token',
                ["read", "update", "create", "delete"]
            )->plainTextToken;

            return response()->json([
                'user' => Auth::user(),
                "token" => $token,
                'message' => 'Successfully logged in',
            ], 200);
        }
        return response()->json([
            'message' => 'These credentials do not match our records!',
        ], 401);
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken();
    
        if ($token) {
            $token->delete();
            return response()->json(['message' => 'Token deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Token not found'], 404);
        }
    }
}
