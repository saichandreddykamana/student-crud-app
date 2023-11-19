<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user_obj  = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ];

            $token = $user->createToken('MyApp')->accessToken;
            return response()->json(['token' => $token, 'user' => $user_obj, 'isAuthenticated' => true], 200);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(){
        if(Auth::check()) {
            Auth::user()->token()->revoke();
        }
        return response()->json(['message' => 'Successfully logged out', 'code' => 200], 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('MyApp')->accessToken;

        return response()->json(['token' => $token], 200);

    }
}
