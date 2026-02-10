@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 pb-80">
        
        <div class="mb-8 border-b border-brand-gold/20 pb-4 flex flex-col xl:flex-row xl:items-end xl:justify-between gap-6">
            <div class="text-center xl:text-left">
                <h1 class="text-3xl font-bold font-serif text-brand-dark">Mapa de Mesas</h1>
                <p class="mt-2 text-brand-gray text-sm">Gestiona el estado de las mesas y los pedidos en tiempo real.</p>
            </div>

            <div class="flex flex-wrap justify-center xl:justify-end gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-5 py-3 flex items-center gap-4">
                    <div class="p-2 bg-brand-gold/10 rounded-lg text-brand-gold">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">FECHA</p>
                        <p class="text-sm font-bold text-brand-dark uppercase whitespace-nowrap">
                            {{ now()->setTimezone('America/Guayaquil')->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}
                        </p>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 px-5 py-3 flex items-center gap-4">
                    <div class="p-2 bg-gray-100 rounded-lg text-gray-500">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">HORA</p>
                        <p id="live-clock" class="text-2xl font-serif font-bold text-brand-dark w-[110px] leading-none">
                            {{ now()->setTimezone('America/Guayaquil')->format('h:i A') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($mesas as $mesa)
                @php
                    $isFree = $mesa->status->value === 'Libre';
                    $hasActiveOrder = $mesa->status->value === 'Ocupada' && $mesa->currentOrder;
                    $isPendingPay = $hasActiveOrder && $mesa->currentOrder->status == \App\Enums\OrderStatus::SERVIDO;
                    
                    $cardClasses = $isFree 
                        ? 'bg-green-50 border-green-200 hover:shadow-green-100' 
                        : ($isPendingPay ? 'bg-amber-50 border-amber-300 ring-2 ring-amber-400 ring-offset-2' : 'bg-red-50 border-red-200');
                    
                    $textClass = $isFree ? 'text-green-800' : ($isPendingPay ? 'text-amber-800' : 'text-red-800');
                @endphp

                <div id="mesa-card-{{ $mesa->id }}" 
                     class="relative p-5 rounded-2xl border-2 shadow-sm hover:shadow-md transition-all duration-300 transform hover:-translate-y-1 {{ $cardClasses }} flex flex-col justify-between min-h-[180px] group overflow-hidden">
                    
                    <div class="absolute top-4 right-4 opacity-10 group-hover:opacity-25 group-hover:scale-110 group-hover:rotate-0 transition-all duration-500 ease-in-out">
                        <svg class="w-20 h-20 {{ $textClass }}" fill="currentColor" viewBox="0 0 24 24">
                            <rect x="7" y="7" width="10" height="10" rx="1.5" />
                            <path d="M10 3h4v3h-4zm0 15h4v3h-4zM3 10v4h3v-4zm15 0v4h3v-4z" />
                        </svg>
                    </div>

                    <div class="text-center mt-4 relative z-10">
                        <h3 class="text-2xl font-bold font-serif {{ $textClass }}">Mesa {{ $mesa->number }}</h3>
                        
                        <div class="flex items-center justify-center gap-1 mt-1 opacity-70 {{ $textClass }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            <span class="text-xs font-medium">{{ $mesa->capacity }} pax</span>
                        </div>
                    </div>

                    <div class="mt-4 text-center z-10">
                        <div id="status-container-{{ $mesa->id }}" class="mb-3">
                            @if($isPendingPay)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-200 text-amber-900 animate-pulse">
                                    PENDIENTE PAGO
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $isFree ? 'bg-green-200 text-green-900' : 'bg-red-200 text-red-900' }}">
                                    {{ $mesa->status->value }}
                                </span>
                            @endif
                        </div>

                        @if($isFree)
                            <a href="{{ route('orders.create', ['table_id' => $mesa->id]) }}" 
                               class="inline-block w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-lg shadow transition-colors">
                                Abrir Pedido
                            </a>
                        @elseif($mesa->currentOrder)
                            <a href="{{ route('orders.show', $mesa->currentOrder->id) }}" 
                               class="inline-block w-full px-4 py-2 bg-brand-dark hover:bg-black text-brand-gold text-sm font-bold rounded-lg shadow transition-colors border border-brand-gold/30">
                                Ver Detalle
                            </a>
                        @else
                            <span class="text-xs text-gray-400 italic">Sin pedido activo</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="active-orders-panel" 
         class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t-4 border-brand-gold shadow-[0_-4px_20px_rgba(0,0,0,0.1)] z-50 transition-all duration-300 ease-in-out h-80 flex flex-col overflow-hidden"
         :class="desktopOpen ? 'lg:left-64' : 'lg:left-0'">
        
        <div class="h-12 min-h-[3rem] px-6 bg-brand-dark text-brand-gold flex justify-between items-center cursor-pointer hover:bg-black transition-colors z-50 relative" 
             onclick="toggleOrdersPanel()">
            <h4 class="font-bold font-serif text-sm uppercase tracking-widest flex items-center gap-2 select-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                Pedidos en Curso
                <span id="orders-count" class="bg-brand-red text-white text-[10px] px-1.5 py-0.5 rounded-full ml-1">{{ $activeOrders->count() }}</span>
            </h4>
            <div class="flex items-center gap-2 text-xs opacity-70">
                <span id="panel-text-hint">Ocultar</span>
                <svg id="panel-chevron" class="w-5 h-5 transform transition-transform duration-500 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>

        <div id="active-orders-container" class="flex-1 flex gap-4 p-4 overflow-x-auto scrollbar-thin scrollbar-thumb-brand-gold scrollbar-track-gray-100">
            @foreach($activeOrders as $order)
                @php
                    $bgColor = 'bg-white border-gray-200';
                    $progressWidth = '33%';
                    $progressColor = 'bg-gray-400';
                    $statusTextClass = 'text-gray-500';
                    $actionHtml = ''; 

                    if ($order->status->value === 'En Preparación') {
                        $progressWidth = '66%';
                        $progressColor = 'bg-amber-500';
                        $statusTextClass = 'text-amber-600';
                    } else if ($order->status->value === 'Listo') {
                        $progressWidth = '100%';
                        $progressColor = 'bg-green-500';
                        $statusTextClass = 'text-green-600';
                        $actionHtml = 'LISTO';
                    }
                @endphp
                <div id="active-order-{{ $order->id }}" class="{{ $bgColor }} border-2 rounded-2xl shadow-sm min-w-[280px] w-[280px] flex-shrink-0 flex flex-col justify-between p-5 transition-all duration-300 hover:shadow-md hover:border-brand-gold/30 group bg-white">
                    
                    <div class="flex justify-between items-center mb-4">
                        <div class="flex items-baseline gap-1">
                            <span class="text-sm font-bold text-gray-400">#</span>
                            <span class="text-2xl font-serif font-bold text-brand-dark">{{ $order->id }}</span>
                        </div>
                        <div class="px-3 py-1 bg-brand-dark text-brand-gold rounded-lg shadow-sm">
                            <span class="text-xs font-bold uppercase tracking-wider">Mesa</span>
                            <span class="text-lg font-bold ml-1">{{ $order->mesa ? $order->mesa->number : '?' }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="flex justify-between mb-1">
                            <span class="text-[10px] font-bold uppercase tracking-widest {{ $statusTextClass }}">{{ $order->status->value }}</span>
                            <span class="text-[10px] font-bold text-gray-400">{{ $progressWidth }}</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                            <div class="h-2.5 rounded-full {{ $progressColor }} transition-all duration-1000 ease-out" style="width: {{ $progressWidth }}"></div>
                        </div>
                    </div>

                    <div class="action-form-container mt-auto h-10 flex items-end">
                        @if($actionHtml === 'LISTO')
                            <form action="{{ route('orders.update-status', $order->id) }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="status" value="Servido">
                                <button type="submit" class="w-full py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg text-sm shadow-sm transition-colors flex items-center justify-center gap-2 transform active:scale-95">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Servir
                                </button>
                            </form>
                        @else
                            <div class="w-full text-center">
                                <span class="text-xs text-gray-400 italic flex items-center justify-center gap-1">
                                    <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Trabajando...
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            @if($activeOrders->isEmpty())
                <div id="no-orders-msg" class="w-full h-full flex items-center justify-center text-gray-400 italic text-sm">No hay pedidos activos en cocina.</div>
            @endif
        </div>
    </div>
    
    @if(session('invoice_id'))
        <div id="pdf-modal-backdrop" class="fixed inset-0 z-[150] bg-black/60 backdrop-blur-sm transition-opacity duration-300"></div>
        <div id="pdf-modal" class="fixed inset-0 z-[160] flex items-center justify-center p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform transition-all scale-100 animate-fade-in-up border-t-4 border-brand-gold relative">
                <button onclick="closePdfModal()" class="absolute top-2 right-2 text-gray-400 hover:text-brand-red p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                <div class="p-8 text-center">
                    <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-green-100 mb-6 animate-bounce">
                        <svg class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-serif font-bold text-brand-dark mb-2">¡Pedido Cerrado!</h3>
                    <p class="text-gray-500 text-sm mb-8 leading-relaxed">El proceso se completó con éxito. Tu comprobante PDF está listo.</p>
                    <a href="{{ route('invoices.download', session('invoice_id')) }}" onclick="closePdfModal()" class="block w-full py-4 bg-brand-red text-white font-bold rounded-xl shadow-lg hover:bg-red-800 hover:shadow-brand-red/40 hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 group">
                        <svg class="w-6 h-6 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Descargar Ticket PDF
                    </a>
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                function closePdfModal() {
                    const modal = document.getElementById('pdf-modal');
                    const backdrop = document.getElementById('pdf-modal-backdrop');
                    if(modal) modal.remove();
                    if(backdrop) backdrop.remove();
                }
                document.addEventListener('DOMContentLoaded', function() {
                    const link = document.createElement('a');
                    link.href = "{{ route('invoices.download', session('invoice_id')) }}";
                    link.download = "Ticket-{{ session('invoice_id') }}.pdf";
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                });
            </script>
        @endpush
    @endif

    @push('scripts')
        <script>
            function updateClock() {
                const now = new Date();
                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; 
                document.getElementById('live-clock').innerText = `${hours}:${minutes} ${ampm}`;
            }
            setInterval(updateClock, 1000);

            function toggleOrdersPanel() {
                const panel = document.getElementById('active-orders-panel');
                const chevron = document.getElementById('panel-chevron');
                const hint = document.getElementById('panel-text-hint');
                
                if (panel.classList.contains('h-80')) {
                    panel.classList.remove('h-80');
                    panel.classList.add('h-12');
                    chevron.classList.remove('rotate-180');
                    chevron.classList.add('rotate-0');
                    hint.innerText = 'Mostrar';
                } else {
                    panel.classList.remove('h-12');
                    panel.classList.add('h-80');
                    chevron.classList.add('rotate-180');
                    chevron.classList.remove('rotate-0');
                    hint.innerText = 'Ocultar';
                }
            }

            window.addEventListener('load', function () {
                // POLLING STRATEGY FOR ACTIVE ORDERS (5 Seconds)
                setInterval(() => {
                    fetch(window.location.href)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            
                            // 1. Update Active Orders Panel
                            const newContainer = doc.getElementById('active-orders-container');
                            const currentContainer = document.getElementById('active-orders-container');
                            
                            if (newContainer && currentContainer) {
                                if (newContainer.innerHTML !== currentContainer.innerHTML) {
                                    currentContainer.innerHTML = newContainer.innerHTML;
                                }
                            }

                            // 2. Update Order Count Badge
                            const newCount = doc.getElementById('orders-count');
                            const currentCount = document.getElementById('orders-count');
                            if(newCount && currentCount) {
                                currentCount.innerText = newCount.innerText;
                            }

                            // 3. Update Table Statuses (Grid)
                            // We loop through all tables in the new DOM and update if changed
                            const newTables = doc.querySelectorAll('[id^="mesa-card-"]');
                            newTables.forEach(newTable => {
                                const id = newTable.id;
                                const currentTable = document.getElementById(id);
                                if (currentTable && newTable.innerHTML !== currentTable.innerHTML) {
                                    // Replace the whole card to catch class changes (colors) and content
                                    currentTable.outerHTML = newTable.outerHTML;
                                }
                            });
                        })
                        .catch(err => console.error('Error polling updates:', err));
                }, 5000);
            });
        </script>
    @endpush
@endsection