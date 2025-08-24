<?php

namespace App\Http\Controllers;

use App\Models\Temporada;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TemporadaController extends Controller
{
    public function index()
    {
        $temporadas = Temporada::withArticulosCount()->orderBy('nombre')->paginate(15);
        
        return view('sections.temporadas.index', compact('temporadas'));
    }

    public function create()
    {
        return view('sections.temporadas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:temporada,nombre',
        ], [
            'nombre.required' => 'El nombre de la temporada es obligatorio.',
            'nombre.unique' => 'Ya existe una temporada con ese nombre.',
        ]);

        try {
            Temporada::create([
                'nombre' => $request->nombre,
            ]);

            return redirect()->route('temporadas.index')
                ->with('success', 'Temporada creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear temporada: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al crear la temporada. Inténtalo de nuevo.')
                ->withInput();
        }
    }

    public function edit(Temporada $temporada)
    {
        return view('sections.temporadas.edit', compact('temporada'));
    }

    public function update(Request $request, Temporada $temporada)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:temporada,nombre,' . $temporada->id,
        ], [
            'nombre.required' => 'El nombre de la temporada es obligatorio.',
            'nombre.unique' => 'Ya existe una temporada con ese nombre.',
        ]);

        try {
            $temporada->update([
                'nombre' => $request->nombre,
            ]);

            return redirect()->route('temporadas.index')
                ->with('success', 'Temporada actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar temporada: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar la temporada. Inténtalo de nuevo.')
                ->withInput();
        }
    }

    public function destroy(Temporada $temporada)
    {
        try {
            // Verificar si la temporada está siendo usada por artículos
            if ($temporada->articulos()->count() > 0) {
                return redirect()->route('temporadas.index')
                    ->with('error', 'No se puede eliminar la temporada porque está siendo utilizada por artículos.');
            }

            $temporada->delete();

            return redirect()->route('temporadas.index')
                ->with('success', 'Temporada eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar temporada: ' . $e->getMessage());
            return redirect()->route('temporadas.index')
                ->with('error', 'Error al eliminar la temporada. Inténtalo de nuevo.');
        }
    }
}
