<?php

namespace App\Http\Controllers;
use App\Models\Supermercado;

use Illuminate\Http\Request;

class SupermercadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $supermercados = Supermercado::all();

        return view('supermercados.index', compact('supermercados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('supermercados', 'public');
        }

        Supermercado::create([
            'nombre' => $request->nombre,
            'imagen' => $rutaImagen, // será null si no se subió imagen
        ]);

        return redirect()->route('supermercados.index')->with('success', 'Supermercado agregado.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'imagen' => 'required|string|max:255',
        ]);

        $supermercados = Supermercados::findOrFail($id);

        $supermercados->update([
            'nombre' => $request->nombre,
            'imagen' => $request->imagen,
        ]);

        return redirect()->route('supermercados.index')->with('success', 'Supermercado actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supermercados = Supermercado::findOrFail($id);
        $supermercados->delete();

        return redirect()->route('supermercados.index')->with('success', 'Supermercado eliminado.');
    }

}
