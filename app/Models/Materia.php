<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Clase;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Materia extends Model
{
    protected $table = 'materias';
    use HasFactory;

    protected $guarded = [];

    public function clases()
    {
        return $this->hasMany(Clase::class);
    }

    

}
