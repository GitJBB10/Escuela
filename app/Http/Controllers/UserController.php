<?php

namespace App\Http\Controllers;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function __construct()
    {
       //$this->middleware('permission:read_users')->only(['index']);
    }

    public function index()
    {
        return UserResource::collection(User::all());
    }
    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'email'=>'required|email',
            'password'=> 'required',
        ]);

       /*$usuario = User::create($request->all());*/

       $usuario = User::create([
        'name'=> $request->name,
        'email'=> $request->email,
        'password'=> Hash::make($request->password)  // Encriptamos pass
       ]);
      
       return response()->json([
        'status'=> true,
        'message'=> 'User creado satisfactoriamente',
        // Usamos la funcion createToken que nos da auth:sanctun y especificamos el tipo 
        'token'=> $usuario->createToken("API TOKEN")->plainTextToken
      ],200);

    }

    public function show(string $id)
    {
       
    }

    public function filterUser(Request $request)
    {
        $search = $request->query('search');
        $users = User::query()
            ->when($search, function($query) use ($search) {
                $query->where('name', 'like', "%$search%");
            })
            ->with('roles')
            ->get();

    // \Log::info('Usuarios encontrados:', ['users' => $users]);

        return response()->json($users);
    }


    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        $usuario->update([
            'name' => $request['name'],
            'email' => $request['email'],
        ]);

        return response()->json($usuario,200);
    }

    // ********   ASIGNAR UN ROL A UN USUARIO   **************
    public function assignRoles(Request $request, User $user)
   {
    $roles = $request->input('roles');

    if (empty($roles)) {
        return response()->json(['message' => 'No se seleccionaron roles'], 400);
    }

    try {
        $user->roles()->sync($roles); 
        return response()->json(['message' => 'Roles asignados correctamente']);
    } catch (\Exception $e) {
        \Log::error('Error asignando roles:', ['error' => $e->getMessage()]);
        return response()->json(['message' => 'Error al asignar roles'], 500);
    }
   }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
 
    }
}
