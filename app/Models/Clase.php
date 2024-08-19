<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curso;
use App\Models\Clase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Clase extends Model
{
    protected $table = 'clases';
    use HasFactory;

    protected $guarded = [];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function curso()
    {
        /*return $this->belongsToMany(Curso::class,'clases_cursos','curso_id','clase_id');*/
        return $this->belongsTo(Curso::class);
    }

}
