<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matricula;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Periodo extends Model
{
    protected $table = 'periodos';
    use HasFactory;

    protected $guarded = [];

    public function matricula()
    {
        return $this->hasMany(Matricula::class);
    }

}
