<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Persona;
use App\Models\Representante; 
use App\Models\Matricula; 
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estudiante extends Model
{
    protected $table = 'estudiantes';
    use HasFactory;

    protected $guarded = [];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function matricula()
    {
        return $this->hasMany(Matricula::class);
    }

    public function representante()
    {
        return $this->belongsTo(Representante::class);
        /* return $this->belongsToMany(Representante::class,'estudiantes_representantes','representante_id','estudiante_id'); */
    }
}
