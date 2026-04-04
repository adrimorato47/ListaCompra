<?php

namespace App\Http\Controllers;
use App\Models\Lista;
use App\Models\Supermercado;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class ListaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $orden = $request->get('supermercado_id');

        $listas = Lista::when($orden, function ($query) use ($orden) {
                return $query->orderByRaw("supermercado_id = ? DESC", [$orden]);
            })
            ->orderBy('supermercado_id')
            ->get();

        $supermercados = Supermercado::pluck('nombre', 'id');

        return view('listas.index', compact('listas', 'supermercados', 'orden'));
    }


    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'producto'        => 'required|string|max:255', // ← cambiado a 'producto'
            'supermercado_id' => 'required|exists:supermercados,id',
        ]);

        Lista::create([
            'producto'        => $request->producto, // ← cambiado a 'producto'
            'supermercado_id' => $request->supermercado_id,
        ]);

        return redirect()->back()->with('success', '¡Producto añadido!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'producto' => 'required|string|max:255',
            'comprado' => 'required|boolean',
        ]);

        $listas = Lista::findOrFail($id);
        $listas->update([
            'producto' => $request->producto,
            'comprado' => $request->comprado,
        ]);

        return redirect()->route('listas.index')->with('success', 'Producto actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $listas = Lista::findOrFail($id);
        $listas->delete();

        return redirect()->route('listas.index')->with('success', 'Producto eliminado.');
    }


    //En la vista index introducir un botón que permita eliminar todos los productos de la lista. Al hacer clic en este botón, se llamará a este método para eliminar todos los registros de la tabla "listas".
    public function destroyAll()
    {
        Lista::truncate();

        return redirect()->route('listas.index')->with('success', 'Todos los productos eliminados.');
    }
}
