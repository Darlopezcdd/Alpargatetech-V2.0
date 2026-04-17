<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class IngredientController extends Controller
{
    // Listado con paginación
    public function index()
    {
        $ingredients = Ingredient::orderBy('name')->paginate(20);

        return view('inventory.ingredients.index', compact('ingredients'));
    }

    // Formulario de creación
    public function create()
    {
        return view('inventory.ingredients.create');
    }

    // Guardar nuevo ingrediente
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255|unique:ingredients,name',
            'unit'         => 'required|string|max:50',
            'stock_actual' => 'required|numeric|min:0',
            'stock_minimo' => 'required|numeric|min:0',
        ], [
            'name.unique' => 'Ya existe un ingrediente con ese nombre.',
        ]);

        $ingredient = Ingredient::create($data);

        AuditLogger::log('Inventario: Crear ingrediente', "'{$ingredient->name}' — Stock: {$ingredient->stock_actual} {$ingredient->unit}", auth()->id());

        return redirect()->route('admin.ingredients.index')
            ->with('success', "Ingrediente '{$ingredient->name}' creado exitosamente.");
    }

    // Formulario de edición
    public function edit(Ingredient $ingredient)
    {
        return view('inventory.ingredients.edit', compact('ingredient'));
    }

    // Actualizar ingrediente
    public function update(Request $request, Ingredient $ingredient): RedirectResponse
    {
        $data = $request->validate([
            'name'         => "required|string|max:255|unique:ingredients,name,{$ingredient->id}",
            'unit'         => 'required|string|max:50',
            'stock_actual' => 'required|numeric|min:0',
            'stock_minimo' => 'required|numeric|min:0',
        ]);

        $ingredient->update($data);

        AuditLogger::log('Inventario: Actualizar ingrediente', "'{$ingredient->name}' actualizado", auth()->id());

        return redirect()->route('admin.ingredients.index')
            ->with('success', "Ingrediente '{$ingredient->name}' actualizado.");
    }

    // Eliminar ingrediente (soft delete)
    public function destroy(Ingredient $ingredient): RedirectResponse
    {
        $name = $ingredient->name;
        $ingredient->delete();

        AuditLogger::log('Inventario: Eliminar ingrediente', "'{$name}' eliminado", auth()->id());

        return redirect()->route('admin.ingredients.index')
            ->with('success', "Ingrediente '{$name}' eliminado.");
    }
}
