<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'table_id'             => 'required|exists:tables,id',
            'items'                => 'required|array|min:1',
            'items.*.product_id'   => 'required|exists:products,id',
            'items.*.quantity'     => 'required|integer|min:1|max:99',
            'items.*.notes'        => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'table_id.required'      => 'Debes seleccionar una mesa.',
            'table_id.exists'        => 'La mesa seleccionada no existe.',
            'items.required'         => 'El pedido no puede estar vacío.',
            'items.min'              => 'Debes añadir al menos un producto.',
            'items.*.product_id.required' => 'Cada ítem debe tener un producto.',
            'items.*.quantity.min'   => 'La cantidad mínima es 1.',
            'items.*.quantity.max'   => 'La cantidad máxima por ítem es 99.',
        ];
    }
}
