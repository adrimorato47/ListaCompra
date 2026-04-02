@extends('layouts.app')

@section('title', 'Supermercados')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold mb-4">Lista de supermercados</h1>
     @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('supermercados.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
         <input
        type="text"
        name="nombre"
        placeholder="Nombre del supermercado"
        value="{{ old('nombre') }}"
    >

    <input type="file" name="imagen" id="imagen" />
    <br>
    <button type="submit" class="rounded-md px-3 py-1.5 font-medium bg-green-500 hover:bg-sky-700">Añadir</button>
    </form>


    @forelse ($supermercados as $supermercado)
        <div class="bg-white rounded-xl shadow p-4 mb-3 flex items-center justify-between gap-3">

            {{-- Nombre del producto y supermercado --}}
            <div>
                <span class="font-medium text-gray-800">{{ $supermercado->supermercado }}</span>
                @if($supermercado->imagen)
                    <img
                        src="{{ asset('storage/' . $supermercado->imagen) }}"
                        alt="{{ $supermercado->nombre }}"
                        class="w-16 h-16 object-cover rounded"
                    >
                @endif
            </div>

            {{-- FORMULARIO ELIMINAR --}}
            <form
                action="{{ route('supermercados.destroy', $supermercado->id) }}"
                method="POST"
                onsubmit="return confirm('¿Seguro que quieres eliminar este supermercado?')"
            >
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-600 font-medium text-sm">
                    Eliminar
                </button>
            </form>

        </div>
        @empty
            <p class="text-center text-gray-400 py-10">No tienes productos todavía. ¡Añade el primero!</p>
    @endforelse
</div>
