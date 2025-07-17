<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class UpdateConciertoRequest extends FormRequest
{
    /**
     * Campos permitidos para esta solicitud.
     */
    private const CAMPOS_PERMITIDOS = [
        'titulo',
        'lugar',
        'fecha_concierto',
        'precio_entrada'
    ];

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:50',
            'lugar' => 'required|string|max:50',
            'fecha_concierto' => 'required|date_format:Y-m-d H:i',
            'precio_entrada' => 'required|numeric|min:0',
        ];
    }

    /**
     * @return void
     * @throws ValidationException
     */
    protected function prepareForValidation(): void
    {
        $camposRecibidos = array_keys($this->all());
        $camposInvalidos = array_diff($camposRecibidos, self::CAMPOS_PERMITIDOS);

        if (!empty($camposInvalidos)) {
            throw ValidationException::withMessages([
                'campos_invalidos' => ['Campos no permitidos en la solicitud: ' . implode(', ', $camposInvalidos)],
            ]);
        }
    }
}
