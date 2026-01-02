<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        // Obtenemos todas las mesas ordenadas por número
        $mesas = Mesa::orderBy('number')->get();

        return view('mesas.index', compact('mesas'));
    }
}
