<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;
use App\Models\Estudiante;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Representante extends Model
{
    protected $table = 'representantes'; 
    use HasFactory;

    protected $guarded = [];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function estudiantes()
    {
        return $this->hasMany(Estudiante::class);
        /*return $this->belongsToMany(Estudiante::class,'estudiantes_representantes','estudiante_id','representante_id');*/
    }
}
