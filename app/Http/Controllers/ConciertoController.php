<?php

namespace App\Http\Controllers;

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
            'es_gratis' => 'required|boolean',
            'precio_concierto' => 'required',
        ]);

        if ($validateRequest->fails()) {
            $respuesta = [
                'mensaje' => 'Error al validar los datos',
                'errors' => $validateRequest->errors(),
                'status' => 400
            ];
            return response()->json($respuesta, 400);
        }

        $concierto = Concierto::create([
            'titulo' => $request->get('titulo'),
            'lugar' => $request->get('lugar'),
            'fecha_concierto' => $request->get('fecha_concierto'),
            'es_gratis' => $request->get('es_gratis'),
            'precio_concierto' => $request->get('precio_concierto'),
        ]);

        if (!$concierto) {
            $respuesta = [
                'mensaje' => 'Error al crear el concierto',
                'status' => 500
            ];
            return response()->json($respuesta, 500);
        }
        $respuesta = [
            'mensaje' => 'Concierto creado correctamente',
            'status' => 200
        ];
        return response()->json($respuesta, 200);

    }

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
}
