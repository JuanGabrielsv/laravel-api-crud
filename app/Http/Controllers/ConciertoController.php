<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreConciertoRequest;
use App\Http\Requests\UpdateConciertoRequest;
use App\Services\ConciertoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Concierto;
use Illuminate\Support\Facades\Validator;

class ConciertoController extends Controller
{
    protected ConciertoService $conciertoService;
    public function __construct(ConciertoService $conciertoService){
        $this->conciertoService = $conciertoService;
    }
    const CAMPOS_REQUERIDOS = ['titulo', 'lugar', 'fecha_concierto', 'precio_entrada'];

    /**
     * GET - Mostrar todos los conciertos.
     * @return JsonResponse/ JSON con la lista de conciertos o mensaje de error.
     */
    public function index(): JsonResponse
    {
        return $this->conciertoService->index();
    }

    /**
     * GET by id - Buscar concierto por ID.
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        return $this->conciertoService->show($id);
    }

    /**
     * POST - Crear un concierto
     * @param Request $request
     * @return JsonResponse
     */
    public function store(StoreConciertoRequest $request): JsonResponse
    {
            return $this->conciertoService->create($request->validated());
    }

    /**
     * DELETE - Borrar un concierto.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->conciertoService->destroy($id);
    }

    /**
     * UPDATE - Actualizar un concierto completo.
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateConciertoRequest $request, $id): JsonResponse
    {
        return $this->conciertoService->update($id, $request->validated());
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
        $camposEnviados = array_keys($request->all());
        $camposInvalidos = array_diff($camposEnviados, self::CAMPOS_REQUERIDOS);
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
            'precio_entrada' => 'sometimes|required',
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
            'precio_entrada',
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
