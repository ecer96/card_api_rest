<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");

        if (Auth::attempt($credentials)) {
            $user = $request->user();

            $tokenName = Str::uuid()->toString();
            $token = $user->createToken($tokenName, ['id' => $user->id])->accessToken;

            return response()->json(['token' => $token,'user'=>$user->name], 200);
        }

        return response()->json(['Error' => 'The Email or the password were incorrect please try again..'], 401);
    }
}