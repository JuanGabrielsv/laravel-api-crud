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
        'precio_entrada',
        'banda_id'
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

        $rules = [
            'titulo' => 'required|string',
            'lugar' => 'required|string',
            'fecha_concierto' => 'required|date_format:Y-m-d H:i',
            'precio_entrada' => 'required|numeric|min:0',
            'banda_id' => 'required|integer|exists:banda,id'
        ];

        if ($this->isMethod('patch')) {
            foreach ($rules as $field => $rule) {
                $rules[$field] = 'sometimes|' . $rule;
            }
        }

        return $rules;

        //        return [
        //            'titulo' => 'sometimes|string',
        //            'lugar' => 'sometimes|string',
        //            'fecha_concierto' => 'sometimes|date_format:Y-m-d H:i',
        //            'precio_entrada' => 'sometimes|numeric|min:0',
        //            'banda_id' => 'sometimes|integer|exists:banda,id'
        //        ];
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
