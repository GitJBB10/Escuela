<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matricula;
use App\Models\Clase;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    protected $table = 'cursos';
    use HasFactory;

    protected $guarded = [];

    public function matricula()
    {
        return $this->hasMany(Matricula::class);
    }

    public function clases()
    {
       /* return $this->belongsToMany(Clase::class,'clases_cursos','clase_id','curso_id');*/
        return $this->hasMany(Clase::class);
    }

}
