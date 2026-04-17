<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    // Listado de categorías
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();

        return view('admin.categories.index', compact('categories'));
    }

    // Guardar nueva categoría
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ], [
            'name.unique' => 'Ya existe una categoría con ese nombre.',
        ]);

        $category = Category::create($data);

        AuditLogger::log('Menú: Crear categoría', "Categoría '{$category->name}' creada", auth()->id());

        return redirect()->route('admin.categories.index')
            ->with('success', "Categoría '{$category->name}' creada.");
    }

    // Formulario de edición
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    // Actualizar categoría
    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => "required|string|max:255|unique:categories,name,{$category->id}",
        ]);

        $category->update($data);

        AuditLogger::log('Menú: Actualizar categoría', "'{$category->name}' actualizada", auth()->id());

        return redirect()->route('admin.categories.index')
            ->with('success', "Categoría '{$category->name}' actualizada.");
    }

    // Eliminar categoría (soft delete, si no tiene productos)
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', "No puedes eliminar '{$category->name}' porque tiene productos asociados.");
        }

        $name = $category->name;
        $category->delete();

        AuditLogger::log('Menú: Eliminar categoría', "'{$name}' eliminada", auth()->id());

        return redirect()->route('admin.categories.index')
            ->with('success', "Categoría '{$name}' eliminada.");
    }
}
