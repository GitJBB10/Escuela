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
    
   
    Route::resource('/estudiante', EstudianteController::class);
    Route::resource('/profesor', ProfesorController::class);
    Route::resource('/representante', RepresentanteController::class);
    Route::resource('/curso', CursoController::class);
    Route::resource('/periodo', PeriodoController::class);
    Route::resource('/matricula', MatriculaController::class);
    Route::resource('/materia', MateriaController::class);
    Route::resource('/clase', ClaseController::class);
    Route::get('/representante/{id}/estudiantes', [RepresentanteController::class, 'estudiantes']);
    Route::resource('/role', RoleController::class);
    Route::resource('/permission', PermissionController::class);
    Route::post('/role/{role}/permissions', [RoleController::class, 'assignPermissions']);
} );

Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);

Route::get('/user/filter', [UserController::class, 'filterUser']);
Route::resource('/user', UserController::class);
Route::post('/user/{user}/roles', [UserController::class,'assignRoles']);

Route::resource('/permission', PermissionController::class);
Route::post('/role/{role}/permissions', [RoleController::class, 'assignPermissions']);
Route::get('/role/{roleId}/permissions', [RoleController::class, 'getRolePermissions']);