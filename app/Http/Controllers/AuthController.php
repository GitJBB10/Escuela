<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\User;
Use Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        // El metodo "user" nos permite acceder a los datos del usuario autenticado
       // El metodo "attempt" nos permite tratar de logear a un usuario 
       if(!Auth::attempt($request->only(['email','password'])))
       {
        // Si falla la autenticacion !
            return response()->json([
            'status'=> false,
            'message'=> 'Email o Password no son correctos'
            ],401);
       } 

       $user = User::where('email',$request->email)->first();

       return response()->json([
            'status'=> true,
            'message'=> 'Usuario Logeado satisfactoriamente',
            'token'=> $user->createToken("API TOKEN")->plainTextToken  // token que lo identifica
       ],200);
    }

    public function logout(LoginRequest $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
 
}
