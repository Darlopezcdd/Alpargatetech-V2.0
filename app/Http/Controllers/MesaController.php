<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        // Cargamos las mesas y su pedido actual para tener el ID a mano
        $mesas = Mesa::with('currentOrder')->orderBy('number')->get();

        return view('mesas.index', compact('mesas'));
    }
}
