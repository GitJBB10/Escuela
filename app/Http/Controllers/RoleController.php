<?php

namespace App\Http\Controllers;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Http\Request;

class RoleController extends Controller
{
 
    public function __construct()
    {
        //$this->middleware('permission:read_roles')->only(['index']);
    }

    public function index()
    {
        $rol = Role::all();
        return response()-> json($rol,200);

    }

   
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|max:225',
        ]);

        $rol = Role::create([
            'name'=> $request->name,
            'guard_name'=> 'api'
        ]);
        
        return response()->json([
            'status'=> true,
            'message'=> 'Permiso creado satisfactoriamente',
        ],200);
    }


    public function destroy(string $id)
    {
        //
    }

    // ********    ASIGNAR ROLES    ***********
    public function assignRoles(Request $request, User $user)
    {
        $roles = $request->input('roles');
        $user->roles()->sync($roles);

        return response()->json(['message' => 'Roles asignados correctamente']);
    }
    
    // ********    ASIGNAR PERMISOS   ************
    public function assignPermissions(Request $request, $roleId)
    {
        \Log::info('Assigning permissions to role', [
            'role_id' => $roleId,
            'permissions' => $request->input('permissions'),
        ]);
        
        $role = Role::find($roleId);

        if (!$role) {
            return response()->json(['message' => 'Role not found'], 404);
        }

        $permissions = $request->input('permissions');

        if (is_array($permissions)) {
            // Sincroniza los permisos con el rol
            $role->permissions()->sync($permissions);

            return response()->json(['message' => 'Permissions assigned successfully']);
        } else {
            return response()->json(['message' => 'Invalid permissions data'], 400);
        }
    }

    public function getRolePermissions($roleId)
    {
        try {
            // Buscar el rol por su ID junto con sus permisos
            $role = Role::with('permissions')->findOrFail($roleId);

            // Retornar los permisos como respuesta
            return response()->json($role->permissions);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener permisos del rol'], 500);
        }
    }

}
