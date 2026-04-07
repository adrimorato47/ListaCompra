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
    @auth
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
            <option value="">-</option>

            @foreach($supermercados as $id => $nombre)
                {{-- old('supermercado_id') restaura la selección si falla la validación --}}
                <option value="{{ $id }}" {{ old('supermercado_id') == $id ? 'selected' : '' }}>
                    {{ $nombre }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="rounded-md px-3 py-1.5 font-medium bg-green-500 hover:bg-sky-700">AÑADIR</button>
    </form>
@endauth

{{--Aqui empieza el invento--}}
<form method="GET" action="{{ route('listas.index') }}">
    <select name="supermercado_id" onchange="this.form.submit()">
        <option value="">Cualquier orden</option>
        @foreach ($supermercados as $id => $nombre)
            <option value="{{ $id }}" {{ $orden == $id ? 'selected' : '' }}>
                {{ $nombre }}
            </option>
        @endforeach
    </select>
</form>
<table class="w-full">
    @forelse ($listas as $lista)
    <tbody>
        <tr class="bg-white rounded-xl shadow p-4 mb-3 flex items-center justify-between gap-3 p-12">
            <td class="w-2/4 text-2xl">
            {{-- Nombre del producto y supermercado --}}
            <div>
                <span class="font-medium text-gray-800">{{ $lista->producto }}</span>
            </td>
            <td class="w-1/4">
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
            </td>
            {{-- FORMULARIO ELIMINAR --}}
            @auth
                <form
                    action="{{ route('listas.destroy', $lista->id) }}"
                    method="POST"
                    onsubmit="return confirm('¿Está ya en la cesta?')"
                >
                <td class="w-1/4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-md px-3 py-1.5 font-medium bg-red-600 hover:bg-sky-700">
                        Eliminar
                    </button>
                </form>
                </td>
            @endauth
        </tr>
    </tblody>
    @empty
        <p class="text-center text-gray-400 py-10">No tienes productos todavía. ¡Añade el primero!</p>
    @endforelse
</table>
@auth
    <form action="{{route('listas.destroyAll')}}"
        method="POST"
        onsubmit="return confirm('¿Seguro que quieres eliminarlo todo?')"
    >
    @csrf
    @method('DELETE')
    <button type="submit"
    {{--class="rouded-md px-3 py-1.5 font-medium bg-olive-950 text-white hover:bg-olive-50 hover:text-olive-950">--}}
    class="rounded-md px-3 py-1.5 font-medium bg-stone-800 text-white hover:bg-red-700">
        Vaciar lista
    </button>
@endauth
</button>
</form>
</div>
