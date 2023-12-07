<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only(['email', 'password']);
        Validator::make($credentials, [
            'email'=>'required|email',
            'password'=>'required|string'
        ])->validate();
        if(!Auth::attempt($credentials)){
            return response()->json(['message'=>'Invalid credentials'], 400);
        }
        $user = User::where(['email'=>$credentials['email']])->first();
        if(!$user || !Hash::check($credentials['password'], $user->password)){
            return response()->json(['message'=>'Invalid credentials'], 400);
        }
        $data = [
            'email'=>$user['email'],
            'session'=>date_create(),
            'random'=>random_int(200,500)
        ];
        $token = Token::createToken($data);
        return response()->json([
            'access_token'=>$token
        ]);

    }
}
