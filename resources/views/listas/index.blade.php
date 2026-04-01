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
        name="lista"
        placeholder="Nombre del producto..."
        value="{{ old('lista') }}"
    >

    {{-- DESPLEGABLE DE SUPERMERCADOS --}}
    {{-- $supermercados es la colección pluck() que viene del controlador.
         @foreach la recorre pasando $id como clave y $nombre como valor. --}}
    <select name="supermercado_id">
        <option value="">-- Selecciona un supermercado --</option>

        @foreach($supermercados as $id => $nombre)
            {{-- old('supermercado_id') restaura la selección si falla la validación --}}
            <option value="{{ $id }}" {{ old('supermercado_id') == $id ? 'selected' : '' }}>
                {{ $nombre }}
            </option>
        @endforeach
    </select>

    <button type="submit">Añadir producto</button>
</form>
</div>
