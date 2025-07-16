<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Concierto;
use Illuminate\Support\Facades\Validator;

class ConciertoController extends Controller
{
    /**
     * GET - Mostrar todos los conciertos.
     * @return JsonResponse/ JSON con la lista de conciertos o mensaje de error.
     */
    public function index()
    {
        $conciertos = Concierto::all();
        if ($conciertos->isEmpty()) {
            return response()->json(['Mensaje' => 'No existen conciertos'], 404);
        }
        return response()->json(['Conciertos' => $conciertos], 200);
    }

    /**
     * GET by id - Buscar concierto por ID.
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $concierto = Concierto::find($id);

        if ($concierto === null) {
            $repuesta = [
                'Mensaje' => 'El concierto con el id ' . $id . ' no existe',
                'status' => 404
            ];
            return response()->json($repuesta, 404);
        }

        return response()->json(['Concierto' => $concierto], 200);
    }

    /**
     * POST - Crear un concierto
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        //Validamos primero los datos recibidos
        $validateRequest = Validator::make($request->all(), [
            'titulo' => 'required',
            'lugar' => 'required',
            'fecha_concierto' => 'required',
            'precio_concierto' => 'required|numeric',
        ]);

        if ($validateRequest->fails()) {
            $respuesta = [
                'mensaje' => 'Error al validar los datos',
                'errors' => $validateRequest->errors(),
                'status' => 422
            ];
            return response()->json($respuesta, 422);
        }

        try {
            $concierto = Concierto::create([
                'titulo' => $request->get('titulo'),
                'lugar' => $request->get('lugar'),
                'fecha_concierto' => $request->get('fecha_concierto'),
                'precio_concierto' => $request->get('precio_concierto'),
            ]);

            $respuesta = [
                'mensaje' => 'Concierto creado correctamente',
                'status' => 200
            ];
            return response()->json($respuesta, 201);

        } catch (Exception $e) {
            return response()->json([
                'mensaje' => 'Error al crear el concierto',
                'error' => $e->getMessage(), //Quitar en producción
                'status' => 500
            ], 500);

        }
    }

    /**
     * DELETE - Borrar un concierto.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $concierto = Concierto::find($id);

        if ($concierto === null) {
            $repuesta = [
                'Mensaje' => 'El concierto con el id ' . $id . ' no existe',
                'status' => 404
            ];
            return response()->json($repuesta, 404);
        }
        $concierto->delete();

        $respuesta = [
            'mensaje' => 'Concierto eliminado correctamente',
            'status' => 200
        ];
        return response()->json($respuesta, 200);
    }

    /**
     * UPDATE - Actualizar un concierto completo.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {

        $concierto = Concierto::find($id);

        if ($concierto === null) {
            $repuesta = [
                'Mensaje' => 'El concierto con el id ' . $id . ' no existe',
                'status' => 404
            ];
            return response()->json($repuesta, 404);
        }

        $validateRequest = Validator::make($request->all(), [
            'titulo' => 'required',
            'lugar' => 'required',
            'fecha_concierto' => 'required',
            'precio_concierto' => 'required',
        ]);

        if ($validateRequest->fails()) {
            $respuesta = [
                'mensaje' => 'Error al validar los datos',
                'errors' => $validateRequest->errors(),
                'status' => 422
            ];
            return response()->json($respuesta, 422);

        }

        $concierto->titulo = $request->get('titulo');
        $concierto->lugar = $request->get('lugar');
        $concierto->fecha_concierto = $request->get('fecha_concierto');
        $concierto->precio_concierto = $request->get('precio_concierto');

        $concierto->save();

        $respuesta = [
            'mensaje' => 'Concierto actualizado correctamente',
            'status' => 200
        ];

        return response()->json($respuesta, 200);

    }

    /**
     * PATCH - Actualización parcial de concierto.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updatePartial(Request $request, $id)
    {
        $concierto = Concierto::find($id);

        if ($concierto === null) {
            $repuesta = [
                'Mensaje' => 'El concierto con el id ' . $id . ' no existe',
                'status' => 404
            ];
            return response()->json($repuesta, 404);
        }

        //Validamos que solo se pueda pasar los campos que tiene concierto.
        $camposPermitidos = ['titulo', 'lugar', 'fecha_concierto', 'es_gratis', 'precio_concierto'];
        $camposEnviados = array_keys($request->all());
        $camposInvalidos = array_diff($camposEnviados, $camposPermitidos);
        if (!empty($camposInvalidos)) {
            $repuesta = [
                'mensaje' => 'Campos no permitidos en la solicitud',
                'campos_invalidos' => array_values($camposInvalidos),
                'status' => 422
            ];
            return response()->json($repuesta, 422);
        }

        //Validamos para que request no pueda estar vacio.
        if (empty($request->all())) {
            $repuesta = [
                'mensaje' => 'No se ha pasado ningún dato',
                'status' => 422
            ];
            return response()->json($repuesta, 422);
        }

        $validateRequest = Validator::make($request->all(), [
            'titulo' => 'sometimes|required',
            'lugar' => 'sometimes|required',
            'fecha_concierto' => 'sometimes|required',
            'precio_concierto' => 'sometimes|required',
        ]);

        if ($validateRequest->fails()) {
            $respuesta = [
                'mensaje' => 'Error al validar los datos',
                'errors' => $validateRequest->errors(),
                'status' => 422
            ];
            return response()->json($respuesta, 422);
        }

        $campos = [
            'titulo',
            'lugar',
            'fecha_concierto',
            'precio_concierto',
        ];

        foreach ($campos as $campo) {
            if ($request->has($campo)) {
                $concierto->{$campo} = $request->input($campo);
            }
        }

        $concierto->save();

        $respuesta = [
            'mensaje' => 'Concierto actualizado correctamente',
            'status' => 200
        ];

        return response()->json($respuesta, 200);

    }
}
