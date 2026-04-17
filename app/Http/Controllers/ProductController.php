<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Services\AuditLogger;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    // Listado de productos con categoría
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    // Formulario de creación
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.create', compact('categories'));
    }

    // Guardar nuevo producto
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $product = Product::create($data);

        AuditLogger::log('Menú: Crear producto', "'{$product->name}' — \${$product->price}", auth()->id());

        return redirect()->route('admin.products.index')
            ->with('success', "Producto '{$product->name}' creado exitosamente.");
    }

    // Formulario de edición
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    // Actualizar producto
    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'is_active'   => 'boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $product->update($data);

        AuditLogger::log('Menú: Actualizar producto', "'{$product->name}' actualizado", auth()->id());

        return redirect()->route('admin.products.index')
            ->with('success', "Producto '{$product->name}' actualizado.");
    }

    // Eliminar producto (soft delete)
    public function destroy(Product $product): RedirectResponse
    {
        $name = $product->name;
        $product->delete();

        AuditLogger::log('Menú: Eliminar producto', "'{$name}' eliminado del menú", auth()->id());

        return redirect()->route('admin.products.index')
            ->with('success', "Producto '{$name}' eliminado del menú.");
    }
}
