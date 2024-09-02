<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
//Use Auth;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        // El metodo "user" nos permite acceder a los datos del usuario autenticado
       // El metodo "attempt" nos permite tratar de logear a un usuario 
       if(!Auth::guard('web')->attempt($request->only(['email','password'])))
       {
        // Si falla la autenticacion !
            return response()->json([
            'status'=> false,
            'message'=> 'Email o Password no son correctos'
            ],401);
       } 

       $user = User::where('email', $request->email)->with('roles.permissions')->first();

        return response()->json([
        'status'=> true,
        'message'=> 'Usuario Logeado satisfactoriamente',
        'token'=> $user->createToken("API TOKEN")->plainTextToken,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name'),
            'permissions' => $user->roles->flatMap(function($role) {
                return $role->permissions->pluck('name');
            })->unique()
        ]
        ],200);
    }

    public function logout(LoginRequest $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }
 
}
