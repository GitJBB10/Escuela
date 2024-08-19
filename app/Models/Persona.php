<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante;
use App\Models\Profesor;
use App\Models\Representante;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    use HasFactory;
    
    protected $table = 'personas';
    protected $guarded = [];


    public function estudiante()
    {
        return $this->hasOne(Estudiante::class);
    }

    public function profesor()
    {
        return $this->hasOne(Profesor::class);
    }

    public function representante()
    {
        return $this->hasOne(Representante::class);
    }

}
