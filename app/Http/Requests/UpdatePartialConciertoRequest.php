<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdatePartialConciertoRequest extends FormRequest
{

    /**
     *
     */
    private const CAMPOS_PERMITIDOS = [
        'titulo',
        'lugar',
        'fecha_concierto',
        'precio_entrada'
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
            'titulo' => 'sometimes|required|string|max:50',
            'lugar' => 'sometimes|required|string|max:50',
            'fecha_concierto' => 'sometimes|required|date_format:Y-m-d H:i',
            'precio_entrada' => 'sometimes|required|numeric|min:0',
        ];
    }

    /**
     * @return void
     * @throws ValidationException
     */
    /**
     * Validación previa para rechazar campos no permitidos.
     */
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

    /**
     * Asegura que al menos un campo se haya enviado.
     */
    protected function passedValidation(): void
    {
        if (empty($this->all())) {
            abort(response()->json([
                'mensaje' => 'No se ha proporcionado ningún dato para actualizar.'
            ], 422));
        }
    }
}
