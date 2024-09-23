<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClasesExport implements FromCollection, WithHeadings
{
    protected $clases;

    public function __construct($clases)
    {
        $this->clases = $clases;
    }

    public function collection()
    {
        return $this->clases->map(function ($clase) {
            return [
                $clase->curso->nombre_curso, 
                $clase->materia->nombre_materia, 
                $clase->profesor->persona->nombres .' '. $clase->profesor->persona->apellidos,
                $clase->hora_inicio,
                $clase->hora_fin,
                $clase->created_at,
                $clase->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Curso',
            'Materia',
            'Profesor(a)',
            'Hora Inicio',
            'Hora Fin',
            'Fecha de Creación',
            'Fecha de Actualización'
        ];
    }
}
