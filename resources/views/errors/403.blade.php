@extends('layouts.app')

@section('content')
    <div class="min-h-[60vh] flex flex-col items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-xl text-center max-w-md w-full border border-gray-100">
            <div class="mb-6">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-red-100">
                    <svg class="h-12 w-12 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 mb-2">Acceso Denegado</h1>
            <p class="text-gray-500 mb-6">Lo sentimos, no tienes permisos para acceder a esta área. Si crees que es un
                error, contacta al administrador.</p>

            <div class="flex justify-center space-x-4">
                <a href="{{ url()->previous() }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Regresar
                </a>
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Ir al Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection