<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePartialBandaResquest extends FormRequest
{
    private const CAMPOS_PERMITIDOS = [
        'nombre',
        'genero',
        'idioma',
    ];

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
            'nombre' => 'sometimes|string|required|unique:banda,nombre',
            'genero' => 'sometimes|string|required',
            'idioma' => 'sometimes|string|required',
        ];
    }

    protected function prepareForValidation(): void
    {
        $camposRecibidos = array_keys($this->all());
        $camposInvalidos = array_diff($camposRecibidos, self::CAMPOS_PERMITIDOS);

        if (!empty($camposInvalidos)) {
            abort(response()->json([
                'mensaje' => 'Campos no permitidos en la solicitud',
                'campos_invalidos' => array_values($camposInvalidos)
            ], 422));
        }
    }

    protected function passedValidation(): void
    {
        if (empty($this->all())) {
            abort(response()->json([
                'mensaje' => 'No se ha proporcionado ningún dato para actualizar.'
            ], 422));
        }
    }
}
