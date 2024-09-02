<?php

namespace App\Http\Controllers;

//use App\Models\Permission; 
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permisos = Permission::all();
        return response()-> json($permisos,200);

    }

    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'=>'required|max:225',
        ]);

        $usuario = Permission::create([
            'name'=> $request->name,
            'guard_name'=> 'api'
        ]);
        
        return response()->json([
            'status'=> true,
            'message'=> 'Permiso creado satisfactoriamente',
        ],200);
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
