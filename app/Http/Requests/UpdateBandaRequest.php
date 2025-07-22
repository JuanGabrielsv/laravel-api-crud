<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use function PHPUnit\Framework\isEmpty;

class UpdateBandaRequest extends FormRequest
{
    const CAMPOS_PERMITIDOS = [
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
        $rules = [
            'nombre' => 'required|string',
            'genero' => 'required|string',
            'idioma' => 'required|string',
        ];

        if ($this->isMethod('patch')) {
            foreach ($rules as $field => $rule) {
                $rules[$field] = 'sometimes|' . $rule;
            }
        }
        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $camposRecibidos = array_keys($this->all());
        $camposInvalidos = array_diff($camposRecibidos, self::CAMPOS_PERMITIDOS);

        if (!empty($camposInvalidos)) {
            throw ValidationException::withMessages([
                'campos_invalidos' => ['Campos no permitidos en la solicitud: ' . implode(', ', $camposInvalidos)],
            ]);
        }

        if (empty($camposRecibidos)){
            throw ValidationException::withMessages([
                'No hay campos recibidos'
            ]);
        }
    }
}
