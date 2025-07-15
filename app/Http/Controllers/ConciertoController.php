<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concierto;

class ConciertoController extends Controller
{
    public function index() {
        $conciertos = Concierto::all();
        if ($conciertos->isEmpty()) {
            return response()->json(['Mensaje' => 'No existen conciertos'], 404);
        }
        return response()->json(['Conciertos' => $conciertos], 200);
    }
}
