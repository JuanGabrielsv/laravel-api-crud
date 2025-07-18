<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBandaRequest extends FormRequest
{
    private const CAMPOS_REQUERIDOS = ['nombre', 'genero', 'idioma'];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string',
            'genero' => 'required',
            'idioma' => 'required|string'
        ];
    }

    protected function prepareForValidation(): void
    {

        $camposRecibidos = array_keys($this->all());
        $camposInvalidos = array_diff($camposRecibidos, self::CAMPOS_REQUERIDOS);

        if (!empty($camposInvalidos)) {
            abort(response()->json([
                'mensaje' => 'Campos no permitidos en la solicitud',
                'campos_invalidos' => array_values($camposInvalidos)
            ], 422));
        }
    }
}
