<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorteRequest;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use App\Models\Corte;
use Illuminate\Support\Facades\Log;

class CorteController extends Controller
{
    use ImageHandler;

    // Configuración de imágenes para cortes
    private const IMAGE_DIRECTORY = 'src/assets/uploads/cortes';
    private const DEFAULT_IMAGE = 'default-corte.jpg';
    private const IMAGE_OPTIONS = [
        'width' => 450,
        'height' => 600,
        'quality' => 80,
        'format' => 'jpeg'
    ];

    public function index(Request $request)
    {
        if(empty($request->search)){
            $cortes = Corte::orderBy('id', 'desc')->get();
        }else{
            $cortes = Corte::where('id', 'like', '%'.$request->query('search').'%')->get();
        }
        return view('sections.cortes', [
            'cortes' => $cortes,
            'search' => $request->query('search')
        ]);
    }

    public function create()
    {
        return view('sections.cortes-form');
    }

    public function store(CorteRequest $request)
    {
        try {
            Log::info('Creando nuevo corte', ['request' => $request->except(['imagen'])]);
            
            $imageFilename = null;
            
            if($request->hasFile('imagen')) {
                // Validar imagen antes de procesar
                $this->validateImage($request->file('imagen'));
                
                // Procesar y guardar imagen
                $imageFilename = $this->processAndSaveImage(
                    $request->file('imagen'), 
                    self::IMAGE_DIRECTORY, 
                    self::IMAGE_OPTIONS
                );
            } else {
                $imageFilename = self::DEFAULT_IMAGE;
            }

            $corte = Corte::create([
                'numero_corte' => $request->numero_corte,
                'nombre' => $request->nombre,
                'colores' => $request->colores,
                'cantidad' => $request->cantidad,
                'articulos' => $request->articulos,
                'descripcion' => $request->descripcion ?? 'Sin descripcion', 
                'costureros' => $request->costureros,
                'imagen' => $imageFilename,
                'imagen_alt' => $imageFilename,
                'fecha' => $request->fecha,
                'estado' => 0,
                'created_at' => now(),
            ]);
            
            Log::info('Corte creado exitosamente', [
                'corte_id' => $corte->id,
                'imagen' => $imageFilename
            ]);
            
            return to_route('home.index')->with('success', 'Corte creado correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al crear corte', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['imagen'])
            ]);
            
            return to_route('cortes.index')->with('error', 'Error al crear el corte: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $corte = Corte::find($id);
        return view('sections.cortes-show', compact('corte'));
    }

    public function edit($id)
    {
        $corte = Corte::find($id);
        return view('sections.cortes-edit-form', compact('corte'));
    }

    public function update(CorteRequest $request, $id)
    {
        try {
            Log::info('Actualizando corte', ['corte_id' => $id, 'request' => $request->except(['imagen'])]);
            
            $corte = Corte::find($id);
            if (!$corte) {
                throw new \Exception('Corte no encontrado');
            }
            
            $imageFilename = $corte->imagen; // Mantener imagen actual por defecto
            
            if($request->hasFile('imagen')) {
                // Validar nueva imagen
                $this->validateImage($request->file('imagen'));
                
                // Procesar y guardar nueva imagen
                $imageFilename = $this->processAndSaveImage(
                    $request->file('imagen'), 
                    self::IMAGE_DIRECTORY, 
                    self::IMAGE_OPTIONS
                );
                
                // Eliminar imagen anterior si no es la imagen por defecto
                if($corte->imagen !== self::DEFAULT_IMAGE) {
                    $this->deleteImage($corte->imagen, self::IMAGE_DIRECTORY, self::DEFAULT_IMAGE);
                }
            }

            $corte->update([
                'numero_corte' => $request->numero_corte,
                'nombre' => $request->nombre,
                'colores' => $request->colores,
                'cantidad' => $request->cantidad,
                'articulos' => $request->articulos,
                'descripcion' => $request->descripcion,
                'costureros' => $request->costureros,
                'imagen' => $imageFilename,
                'imagen_alt' => $imageFilename,
                'estado' => $request->estado,
                'fecha' => $request->fecha,
                'updated_at' => now(),
            ]);
            
            Log::info('Corte actualizado exitosamente', [
                'corte_id' => $corte->id,
                'imagen' => $imageFilename
            ]);
            
            return to_route('cortes.index')->with('success', 'Corte actualizado correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar corte', [
                'corte_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['imagen'])
            ]);
            
            return to_route('cortes.index')->with('error', 'Error al actualizar el corte: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Log::info('Eliminando corte', ['corte_id' => $id]);
            
            $corte = Corte::find($id);
            if (!$corte) {
                throw new \Exception('Corte no encontrado');
            }
            
            // Eliminar imagen si no es la imagen por defecto
            if($corte->imagen !== self::DEFAULT_IMAGE) {
                $this->deleteImage($corte->imagen, self::IMAGE_DIRECTORY, self::DEFAULT_IMAGE);
            }
            
            $corte->delete();
            
            Log::info('Corte eliminado exitosamente', ['corte_id' => $id]);
            return to_route('cortes.index')->with('success', 'Corte eliminado correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar corte', [
                'corte_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return to_route('cortes.index')->with('error', 'Error al eliminar el corte: ' . $e->getMessage());
        }
    }
}
