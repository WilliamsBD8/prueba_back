<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{ 
    public function login(Request $request){
        $email = $request['email'];
        $password = Hash::make($request['password']);
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
              'success' => false,
              'message' => 'Datos invalidos'
            ], 200); 
          }
      

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['success'=> true,'access_token' => $token, 'token_type' => 'Bearer'], 200);
    }

    public function user(Request $request){
        return $request->user();
    }
}
