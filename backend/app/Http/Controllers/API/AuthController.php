<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Hash;

class AuthController extends Controller
{
    /**
     * Handle user login coming from Vue frontend.
     *
     * @param Request $request The login request object.
     * @return \Illuminate\Http\JsonResponse The JSON response with the authentication token and user object.
     */
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

    /**
     * Log out the user.
     *
     * Revoke the authentication token of the authenticated user and return a JSON response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(){
        if(Auth::check()) {
            Auth::user()->token()->revoke();
        }
        return response()->json(['message' => 'Successfully logged out', 'code' => 200], 200);
    }
    
    /**
     * Handle user registration coming from the Vue frontend.
     *
     * @param Request $request The registration request object.
     * @return \Illuminate\Http\JsonResponse The JSON response with the generated authentication token.
     */
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
