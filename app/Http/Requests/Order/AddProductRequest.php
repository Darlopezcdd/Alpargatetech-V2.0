<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class AddProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:99',
            'notes'      => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Selecciona un producto.',
            'product_id.exists'   => 'El producto seleccionado no existe.',
            'quantity.min'        => 'La cantidad mínima es 1.',
            'quantity.max'        => 'La cantidad máxima es 99.',
        ];
    }
}
