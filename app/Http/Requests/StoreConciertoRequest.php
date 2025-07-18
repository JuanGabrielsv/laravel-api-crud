<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class StoreConciertoRequest extends FormRequest
{

    private const CAMPOS_REQUERIDOS = ['titulo', 'lugar', 'fecha_concierto', 'precio_entrada', 'banda_id'];

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'required|string|max:50',
            'lugar' => 'required|string|max:50',
            'fecha_concierto' => 'required|date_format:Y-m-d H:i',
            'precio_entrada' => 'required|numeric|min:0',
            'banda_id' => 'required|exists:banda,id',
        ];
    }

    //Voy a dejar esto para tenerlo como ejemplo, pero se podría usar los mensajes por defecto.
    public function messages(): array
    {
        return [
            'titulo.required' => 'El campo titulo es obligatorio.',
            'lugar.required' => 'El campo lugar es obligatorio.',
            'fecha_concierto.required' => 'El campo fecha es obligatorio.',
            'fecha_concierto.date_format' => 'La fecha debe tener el formato: YYYY-MM-DD HH:MM',
            'precio_entrada.required' => 'El campo precio entrada es obligatorio.',
            'precio_entrada.numeric' => 'El precio debe ser un número.',
            'precio_entrada.min' => 'El precio no puede ser negativo.',
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
