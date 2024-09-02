<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use App\Models\Representante;
use App\Http\Resources\RepresentanteResource;
use App\Http\Resources\EstudianteResource;
use App\Http\Requests\RepresentanteRequest;
use Illuminate\Http\Resources\Json\JsonResource;

use Illuminate\Support\Facades\Hash;

class RepresentanteController extends Controller
{

    public function __construct()
    {
      /*  $this->middleware('permission:read_representantes')->only(['index', 'show']);
        $this->middleware('permission:create_representantes')->only('store');
        $this->middleware('permission:update_representantes')->only('update');
        $this->middleware('permission:delete_representantes')->only('destroy');
    */
    }

    public function index()
    {
        return RepresentanteResource::collection(Representante::with('persona')->get());
    }


    public function store(RepresentanteRequest $request)
    {
        $personaData = [
            'nombres' => $request['nombres'],
            'apellidos' => $request['apellidos'],
            'mail' => $request['mail'],
            'genero' => $request['genero'],
            'f_nacimiento' => $request['f_nacimiento'],
            'direccion' => $request['direccion'],
         ];
   
         $representanteData = [
              'identificacion' => $request['identificacion'],
              'parentesco' => $request['parentesco'],
              'telefono' => $request['telefono'],
         ];

         $persona = Persona::create($personaData); 
         $representante = new Representante($representanteData);
         $persona->representante()->save($representante); 

         return new RepresentanteResource($representante->load('persona'));
    }


    public function show(string $id)
    {
        $representante = Representante::with('persona')->findOrFail($id);
        return new RepresentanteResource($representante); 
    }

  
    public function update(RepresentanteRequest $request, string $id)
    {
        $representante = Representante::findOrFail($id);
        $persona = $representante->persona;

        $personaData = [
            'nombres' => $request['nombres'],
            'apellidos' => $request['apellidos'],
            'mail' => $request['mail'],
            'genero' => $request['genero'],
            'f_nacimiento' => $request['f_nacimiento'],
            'direccion' => $request['direccion'],
         ];
   
         $representanteData = [
              'identificacion' => $request['identificacion'],
              'parentesco' => $request['parentesco'],
              'telefono' => $request['telefono'],
         ];

        $persona->update($personaData);
        $representante->update($representanteData);
        return new RepresentanteResource($representante->load('persona'));

    }


    public function destroy(string $id)
    {
        $representante = Representante::findOrFail($id);
        $representante->delete();
        $representante->persona->delete();

        return response()->json(NULL, 204);
    }


    public function estudiantes($id)
    {
        $representante = Representante::findOrFail($id);

        // Obtener los nombres y apellidos de los estudiantes relacionados
        $estudiantes = $representante->estudiantes()->with('persona')->get();

        // Extraer nombres y apellidos de cada estudiante
        $nombresApellidos = $estudiantes->map(function ($estudiante) {
            return [
                'nombres' => $estudiante->persona->nombres.' '.$estudiante->persona->apellidos,
            ];
        });

        return response()->json($nombresApellidos);
    }


}
