@extends('layouts.app')

@section('title', 'Listas')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-4">
  <h1 class="text-2xl font-bold mb-4">Listas de la compra</h1>
  <!-- Contenido de la vista -->
   @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('listas.store') }}" method="POST">
    @csrf

    {{-- CAMPO NOMBRE DEL PRODUCTO --}}
    <input
        type="text"
        name="producto"
        placeholder="Nombre del producto"
        value="{{ old('lista') }}"
    >

    {{-- DESPLEGABLE DE SUPERMERCADOS --}}
    {{-- $supermercados es la colección pluck() que viene del controlador.
         @foreach la recorre pasando $id como clave y $nombre como valor. --}}
    <select name="supermercado_id">
        <option value="">Cualquiera</option>

        @foreach($supermercados as $id => $nombre)
            {{-- old('supermercado_id') restaura la selección si falla la validación --}}
            <option value="{{ $id }}" {{ old('supermercado_id') == $id ? 'selected' : '' }}>
                {{ $nombre }}
            </option>
        @endforeach
    </select>

    <button type="submit" class="rounded-md px-3 py-1.5 font-medium bg-green-500 hover:bg-sky-700">AÑADIR</button>
</form>

{{--Aqui empieza el invento--}}
@forelse ($listas as $lista)
<div class="bg-white rounded-xl shadow p-4 mb-3 flex items-center justify-between gap-3">

    {{-- Nombre del producto y supermercado --}}
    <div>
        <span class="font-medium text-gray-800">{{ $lista->producto }}</span>

        @if($lista->supermercado)
            <img
                src="{{ asset('storage/' . $lista->supermercado->imagen) }}"
                alt="{{ $lista->supermercado->nombre }}"
                class="w-16 h-16 object-cover rounded"
            >
        @else
            <span class="text-sm text-gray-400 ml-2">Sin supermercado</span>
        @endif
    </div>

    {{-- FORMULARIO ELIMINAR --}}
    <form
        action="{{ route('listas.destroy', $lista->id) }}"
        method="POST"
        onsubmit="return confirm('¿Seguro que quieres eliminar este producto?')"
    >
        @csrf
        @method('DELETE')
        <button type="submit" class="rounded-md px-3 py-1.5 font-medium bg-red-600 hover:bg-sky-700">
            Eliminar
        </button>
    </form>

</div>
@empty
    <p class="text-center text-gray-400 py-10">No tienes productos todavía. ¡Añade el primero!</p>
@endforelse
</div>
