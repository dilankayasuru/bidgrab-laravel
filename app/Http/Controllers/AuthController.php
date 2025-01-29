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
            Validator::make($request->only('name', 'email', 'password', 'device_name'), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&#]/'],
                'device_name' => 'required'
            ])->validate();

            $user = User::create([
                'name' => $request["name"],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);

            $token = $user->createToken(
                $request->device_name,
                ["read", "update", "create", "delete"]
            )->plainTextToken;

            return response()->json(['token' => $token, "user" => $user], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'device_name' => 'required',
            ]);

            if (Auth::attempt($request->only('email', 'password'))) {

                $token = Auth::user()->createToken(
                    $request->device_name,
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
        } catch (ValidationException $validationException) {
            return response()->json([
                'message' => $validationException->getMessage(),
            ], 401);
        }
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
