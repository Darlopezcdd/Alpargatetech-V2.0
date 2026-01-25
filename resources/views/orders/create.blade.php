@extends('layouts.app')

@section('content')
    <div x-data="{ items: [] }" style="display: flex; gap: 20px;">
        <div style="flex: 2;">
            <h2>Menú de La Casa de Alfonso (Nuevo Pedido)</h2>
            @foreach($categories as $category)
                <fieldset style="margin-bottom: 20px; border-radius: 8px; border: 1px solid #ddd;">
                    <legend style="padding: 0 10px; font-weight: bold;">{{ $category->name }}</legend>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; padding: 10px;">
                        @foreach($category->products as $product)
                            <div style="border: 1px solid #eee; padding: 10px; background: #fafafa;">
                                <strong>{{ $product->name }}</strong> - ${{ number_format($product->price, 2) }}
                                <div style="margin-top: 5px;">
                                    <button type="button"
                                            @click="items.push({ id: {{ $product->id }}, name: '{{ $product->name }}', price: {{ $product->price }}, quantity: 1 })"
                                            style="background: #007bff; color: white; border: none; padding: 5px; cursor: pointer;">
                                        Añadir a la comanda
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </fieldset>
            @endforeach
        </div>

        <div style="flex: 1; background: #f9f9f9; padding: 15px; border: 1px solid #ccc;">
            <h3>Nuevo Pedido - Mesa {{ $mesa->number }}</h3>
            <p style="color: #666; font-size: 0.8em;">* El pedido no se creará hasta que confirmes.</p>
            <hr>

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <input type="hidden" name="table_id" value="{{ $mesa->id }}">

                <table style="width: 100%;">
                    <template x-for="(item, index) in items" :key="index">
                        <tr>
                            <td>
                                <input type="hidden" :name="'items['+index+'][product_id]'" :value="item.id">
                                <input type="number" :name="'items['+index+'][quantity]'" x-model="item.quantity" style="width: 40px; border: 1px solid #ccc;">
                                <span x-text="item.name"></span>
                            </td>
                            <td style="text-align: right;">
                                $<span x-text="(item.price * item.quantity).toFixed(2)"></span>
                                <button type="button" @click="items.splice(index, 1)" style="color: red; border: none; background: none; cursor: pointer;">x</button>
                            </td>
                        </tr>
                    </template>
                </table>

                <hr>
                <h2 style="text-align: right;">Total: $<span x-text="items.reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2)"></span></h2>

                <form action="{{ route('orders.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="table_id" value="{{ $mesa->id }}">

                    <div style="margin-top: 15px;">
                        <button type="submit" style="width: 100%; padding: 10px; background: #28a745; color: white; border: none; margin-bottom: 5px;">
                            SOLO GUARDAR PEDIDO
                        </button>

                        <input type="hidden" name="send_to_kitchen" id="send_input" value="0">
                        <button type="submit"
                                onclick="document.getElementById('send_input').value = '1'"
                                style="width: 100%; padding: 15px; background: #ffc107; font-weight: bold; border: none; cursor: pointer;">
                            CREAR Y ENVIAR A COCINA
                        </button>
                    </div>
                </form>
            </form>
        </div>
    </div>
@endsection
