<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        try {
            $credencials = $request->validate([
                'email'=>'required|email',
                'password'=>'required'
            ]);
            if(! Auth::attempt($credencials)){
                return response()->json(['message'=>'Credencials invalidas'],401);
            }

            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'user'=>$user,
                'token'=>$token
            ]);
        } catch (\Throwable $th) {
            return response()->json(['error'=>$th->getMessage()]);
        }


    }

    public function logout(Request $request){
            try {
                $request->user()->currentAccessToken()->delete;
                return response()->json(['message'=>'logout done'],401);
            } catch (\Throwable $th) {
                return response()->json(['error'=>$th->getMessage()]);
            }
        }
}
