<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'required|in:Efectivo,Tarjeta,Transferencia',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => 'Selecciona un método de pago.',
            'payment_method.in'       => 'El método de pago no es válido.',
        ];
    }
}
