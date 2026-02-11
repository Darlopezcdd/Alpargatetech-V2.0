@extends('layouts.app')

@section('content')
    <div class="animate-fade-in-up">

        {{-- Header --}}
        <div class="sm:flex sm:items-end sm:justify-between mb-10 border-b border-brand-gold/20 pb-6">
            <div>
                <h1 class="text-3xl font-bold font-serif text-brand-dark tracking-tight">Panel de Auditoría y Control</h1>
                <p class="mt-2 text-sm text-brand-gray">Monitoreo segmentado de actividades críticas del sistema.</p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center gap-3">
                <div class="flex items-center gap-2 px-4 py-2 bg-green-50 border border-green-200 rounded-full">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-bold text-green-700 uppercase tracking-wider">En vivo</span>
                </div>
            </div>
        </div>

        {{-- Category sections --}}
        <div class="space-y-10">

            {{-- 1. ACCESOS Y SEGURIDAD --}}
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2.5 bg-blue-50 rounded-xl text-blue-600 border border-blue-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-brand-dark font-serif">Accesos y Seguridad</h2>
                        <p class="text-xs text-brand-gray">Inicios de sesión y actividad de autenticación</p>
                    </div>
                </div>
                @include('admin.audit_logs.partials.table', ['logs' => $accessLogs, 'color' => 'blue'])
            </section>

            {{-- 2. GESTIÓN DE USUARIOS --}}
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2.5 bg-purple-50 rounded-xl text-purple-600 border border-purple-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-brand-dark font-serif">Gestión de Usuarios</h2>
                        <p class="text-xs text-brand-gray">Creación, edición y eliminación de cuentas</p>
                    </div>
                </div>
                @include('admin.audit_logs.partials.table', ['logs' => $userLogs, 'color' => 'purple'])
            </section>

            {{-- 3. PEDIDOS Y COCINA --}}
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2.5 bg-orange-50 rounded-xl text-orange-600 border border-orange-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-brand-dark font-serif">Pedidos y Operaciones</h2>
                        <p class="text-xs text-brand-gray">Registro de pedidos, cambios de estado y productos</p>
                    </div>
                </div>
                @include('admin.audit_logs.partials.table', ['logs' => $orderLogs, 'color' => 'orange'])
            </section>

            {{-- 4. PAGOS Y CAJA --}}
            <section>
                <div class="flex items-center gap-3 mb-4">
                    <div class="p-2.5 bg-green-50 rounded-xl text-green-600 border border-green-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-brand-dark font-serif">Finanzas y Pagos</h2>
                        <p class="text-xs text-brand-gray">Cobros, checkouts y transacciones monetarias</p>
                    </div>
                </div>
                @include('admin.audit_logs.partials.table', ['logs' => $paymentLogs, 'color' => 'green'])
            </section>

            {{-- 5. OTROS EVENTOS --}}
            @if($otherLogs->count() > 0)
                <section>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="p-2.5 bg-gray-100 rounded-xl text-brand-gray border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-brand-dark font-serif">Otros Eventos</h2>
                            <p class="text-xs text-brand-gray">Actividades no categorizadas</p>
                        </div>
                    </div>
                    @include('admin.audit_logs.partials.table', ['logs' => $otherLogs, 'color' => 'gray'])
                </section>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setInterval(function () {
                if (!document.querySelector('.modal-open')) {
                    fetch(window.location.href)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newContent = doc.querySelector('.space-y-10');
                            const oldContent = document.querySelector('.space-y-10');
                            if (newContent && oldContent) {
                                oldContent.innerHTML = newContent.innerHTML;
                            }
                        })
                        .catch(err => console.error('Error auto-refreshing logs:', err));
                }
            }, 15000);
        });
    </script>
@endsection