@extends('layouts.app')

@section('content')
    <div class="container">
        <div style="margin-bottom: 30px;">
            <h1 style="font-weight: 800; color: #1f2937;">Dashboard Operativo</h1>
            <p style="color: #6b7280;">Bienvenido de nuevo, <strong>{{ Auth::user()->name }}</strong></p>
        </div>

        {{-- Stats Grid --}}
        <div
            style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px;">
            <!-- Card 1: Ventas Hoy -->
            <div
                style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-left: 5px solid #10b981;">
                <p style="margin: 0; color: #6b7280; font-size: 0.9em; font-weight: 600; text-transform: uppercase;">Ventas
                    de Hoy</p>
                <h2 style="margin: 10px 0 0; font-size: 2.5em; color: #111827;">${{ number_format($salesToday, 2) }}</h2>
            </div>

            <!-- Card 2: Pedidos Hoy -->
            <div
                style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-left: 5px solid #3b82f6;">
                <p style="margin: 0; color: #6b7280; font-size: 0.9em; font-weight: 600; text-transform: uppercase;">Pedidos
                    Procesados</p>
                <h2 style="margin: 10px 0 0; font-size: 2.5em; color: #111827;">{{ $ordersToday }}</h2>
            </div>

            <!-- Card 3: Cocina Pendiente -->
            <div
                style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border-left: 5px solid #f59e0b;">
                <p style="margin: 0; color: #6b7280; font-size: 0.9em; font-weight: 600; text-transform: uppercase;">En
                    Cocina</p>
                <h2 style="margin: 10px 0 0; font-size: 2.5em; color: #111827;">{{ $pendingOrders }}</h2>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                <h3 style="margin-top: 0;">Acciones Rápidas</h3>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="{{ route('mesas.index') }}"
                        style="text-decoration: none; background: #1f2937; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 500;">Ver
                        Mesas</a>
                    <a href="{{ route('kitchen.index') }}"
                        style="text-decoration: none; background: #4b5563; color: white; padding: 10px 20px; border-radius: 6px; font-weight: 500;">Monitor
                        Cocina</a>
                </div>
            </div>
        </div>
    </div>
@endsection