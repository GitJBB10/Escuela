<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstudianteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombres' => 'required|string|max:60',
            'identificacion' => 'required|string|max:10',
            'apellidos' => 'required|string|max:60',
            'mail' => 'required|string|email|max:120|unique:persona',
            'genero' => 'required|string',
            'f_nacimiento' => 'required|date',
            'direccion' => 'required|string|max:200',
        ];
    }
}
