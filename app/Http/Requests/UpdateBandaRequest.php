<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBandaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Usamos Rule::when() para aplicar 'sometimes' solo para peticiones PATCH.
        // Es una forma más moderna y legible de Laravel.
        $requiredRule = Rule::when($this->isMethod('put'), 'required', 'sometimes');

        return [
            'nombre' => [$requiredRule, 'string', 'max:255'],
            'idioma' => [$requiredRule, 'string'],

            // --- REGLAS CORREGIDAS PARA GÉNEROS ---
            'generos_musicales'   => [$requiredRule, 'array'],
            'generos_musicales.*' => ['integer', 'exists:genero_musical,id'],
        ];
    }
}
