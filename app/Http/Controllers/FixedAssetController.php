<?php

namespace App\Http\Controllers;

use App\Models\FixedAsset;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class FixedAssetController extends Controller
{
    // Listado de activos fijos
    public function index()
    {
        $assets = FixedAsset::orderBy('name')->paginate(20);

        return view('inventory.fixed-assets.index', compact('assets'));
    }

    // Formulario de creación
    public function create()
    {
        return view('inventory.fixed-assets.create');
    }

    // Guardar nuevo activo
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'quantity'    => 'required|integer|min:1',
            'status'      => 'required|in:Operativo,En reparación,Dado de baja',
        ]);

        $asset = FixedAsset::create($data);

        AuditLogger::log('Inventario: Crear activo', "'{$asset->name}' — {$asset->quantity} unidades", auth()->id());

        return redirect()->route('admin.fixed-assets.index')
            ->with('success', "Activo '{$asset->name}' registrado exitosamente.");
    }

    // Formulario de edición
    public function edit(FixedAsset $fixedAsset)
    {
        return view('inventory.fixed-assets.edit', compact('fixedAsset'));
    }

    // Actualizar activo
    public function update(Request $request, FixedAsset $fixedAsset): RedirectResponse
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'quantity'    => 'required|integer|min:0',
            'status'      => 'required|in:Operativo,En reparación,Dado de baja',
        ]);

        $fixedAsset->update($data);

        AuditLogger::log('Inventario: Actualizar activo', "'{$fixedAsset->name}' actualizado", auth()->id());

        return redirect()->route('admin.fixed-assets.index')
            ->with('success', "Activo '{$fixedAsset->name}' actualizado.");
    }

    // Eliminar activo (soft delete)
    public function destroy(FixedAsset $fixedAsset): RedirectResponse
    {
        $name = $fixedAsset->name;
        $fixedAsset->delete();

        AuditLogger::log('Inventario: Eliminar activo', "'{$name}' eliminado", auth()->id());

        return redirect()->route('admin.fixed-assets.index')
            ->with('success', "Activo '{$name}' eliminado.");
    }
}
