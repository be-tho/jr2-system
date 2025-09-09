<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::withArticulosCount()->orderBy('nombre')->paginate(15);
        
        return view('sections.categorias.index', compact('categorias'));
    }

    public function create()
    {
        return view('sections.categorias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categoria,nombre',
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
        ]);

        try {
            Categoria::create([
                'nombre' => $request->nombre,
            ]);

            // Limpiar caché relacionado
            cache()->forget('categorias_for_filters');
            cache()->forget('categorias_for_form');

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear categoría: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al crear la categoría. Inténtalo de nuevo.')
                ->withInput();
        }
    }

    public function edit(Categoria $categoria)
    {
        return view('sections.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:categoria,nombre,' . $categoria->id,
        ], [
            'nombre.required' => 'El nombre de la categoría es obligatorio.',
            'nombre.unique' => 'Ya existe una categoría con ese nombre.',
        ]);

        try {
            $categoria->update([
                'nombre' => $request->nombre,
            ]);

            // Limpiar caché relacionado
            cache()->forget('categorias_for_filters');
            cache()->forget('categorias_for_form');

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar categoría: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Error al actualizar la categoría. Inténtalo de nuevo.')
                ->withInput();
        }
    }

    public function destroy(Categoria $categoria)
    {
        try {
            // Verificar si la categoría está siendo usada por artículos
            if ($categoria->articulos()->count() > 0) {
                return redirect()->route('categorias.index')
                    ->with('error', 'No se puede eliminar la categoría porque está siendo utilizada por artículos.');
            }

            $categoria->delete();

            // Limpiar caché relacionado
            cache()->forget('categorias_for_filters');
            cache()->forget('categorias_for_form');

            return redirect()->route('categorias.index')
                ->with('success', 'Categoría eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría: ' . $e->getMessage());
            return redirect()->route('categorias.index')
                ->with('error', 'Error al eliminar la categoría. Inténtalo de nuevo.');
        }
    }
}
