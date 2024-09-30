<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\RepresentanteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\MatriculaController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::middleware('auth:sanctum')->group(function(){

    // ****  Revisar  *****
    
    
    Route::resource('/profesor', ProfesorController::class)
    ->middleware([
        'index' => 'permission:read_profesores',
        'store' => 'permission:create_profesores',
        'show' => 'permission:read_profesores',
        'update' => 'permission:update_profesores',
        'destroy' =>'permission:delete_profesores',
    ]);

    Route::resource('/representante', RepresentanteController::class);
   /* ->middleware([
        'index' => 'permission:read_representantes',
        'store' => 'permission:create_representantes',
        'show' => 'permission:read_representantes',
        'update' => 'permission:update_representantes',
        'destroy' =>'permission:delete_representantes',
        'estudiantes' =>'permission:read_representantes',
    ]);*/

    Route::resource('/curso', CursoController::class);
     /*   ->only(['store', 'show', 'update', 'destroy'])
        ->middleware([
            'store' => 'permission:create_cursos',
            'show' => 'permission:read_cursos',
            'update' => 'permission:update_cursos',
            'destroy' =>'permission:delete_cursos',
        ]);*/

    Route::resource('/periodo', PeriodoController::class)
    ->middleware([
        'index' => 'permission:read_periodos',
        'store' => 'permission:manager_periodos',
        'show' => 'permission:read_periodos',
        'update' => 'permission:manager_periodos',
        'destroy' =>'permission:manager_periodos',
    ]);

    // ****  Revisar  *****
    Route::resource('/matricula', MatriculaController::class)
    ->middleware([
        'index' => 'permission:read_matriculas',
        'store' => 'permission:crear_matriculas',
        'show' => 'permission:read_matriculas',
        'update' => 'permission:update_matriculas',
        //'destroy' =>'permission:delete_matriculas',
    ]);

    Route::resource('/materia', MateriaController::class)
    ->middleware([
        //'index' => 'permission:read_materia',
        'store' => 'permission:create_materia',
        'show' => 'permission:read_materia',
        'update' => 'permission:update_materia',
        //'destroy' =>'permission:delete_materia',
    ]);    

    
    
    Route::get('/representante/{id}/estudiantes', [RepresentanteController::class, 'estudiantes']);
    Route::resource('/role', RoleController::class);
    Route::resource('/permission', PermissionController::class);
    Route::post('/role/{role}/permissions', [RoleController::class, 'assignPermissions']);

    Route::get('/user/filter', [UserController::class, 'filterUser']);
    Route::resource('/user', UserController::class); //->middleware(['permission:read_users']);
    Route::post('/user/{user}/roles', [UserController::class,'assignRoles']);

    Route::resource('/permission', PermissionController::class);
    Route::post('/role/{role}/permissions', [RoleController::class, 'assignPermissions']);
    Route::get('/role/{roleId}/permissions', [RoleController::class, 'getRolePermissions']);

    Route::post('/logout',[AuthController::class,'logout']);

} );

Route::resource('/estudiante', EstudianteController::class);

Route::get('/clase/reporte', [ClaseController::class, 'reporteClases']);

Route::resource('/clase', ClaseController::class);
Route::get('/clase/exportar', [ClaseController::class, 'export']);

Route::post('/login',[AuthController::class,'login']);