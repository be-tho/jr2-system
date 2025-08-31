<?php

namespace App\Http\Controllers;

use App\Http\Requests\CorteRequest;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use App\Models\Corte;
use App\Repositories\CorteRepository;
use Illuminate\Support\Facades\Log;

class CorteController extends Controller
{
    use ImageHandler;

    protected $corteRepository;

    // Configuración de imágenes para cortes
    private const IMAGE_DIRECTORY = 'src/assets/uploads/cortes';
    private const DEFAULT_IMAGE = 'default-corte.svg';
    private const IMAGE_OPTIONS = [
        'width' => 450,
        'height' => 600,
        'quality' => 80,
        'format' => 'jpeg'
    ];

    public function __construct(CorteRepository $corteRepository)
    {
        $this->corteRepository = $corteRepository;
    }

    public function index(Request $request)
    {
        // Preparar filtros
        $filters = [
            'search' => $request->get('search'),
            'estado' => $request->get('estado'),
            'fecha' => $request->get('fecha'),
            'order_by' => $request->get('order_by', 'latest'),
            'order_direction' => $this->getOrderDirection($request->get('order_by', 'latest')),
        ];

        // Obtener cortes paginados con filtros
        $cortes = $this->corteRepository->getPaginatedWithFilters($filters, 12);

        return view('sections.cortes', compact('cortes'));
    }

    /**
     * Determinar la dirección del ordenamiento basado en el tipo de orden
     */
    private function getOrderDirection(string $orderBy): string
    {
        $ascendingOrders = ['oldest', 'numero_asc'];
        return in_array($orderBy, $ascendingOrders) ? 'asc' : 'desc';
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

            // Procesar colores JSON del formulario
            $colores = $this->processColoresFromForm($request->input('colores'));

            $corte = Corte::create([
                'numero_corte' => $request->numero_corte,
                'tipo_tela' => $request->tipo_tela,
                'colores' => $colores,
                'cantidad_total' => $request->cantidad_total,
                'articulos' => $request->articulos,
                'descripcion' => $request->descripcion,
                'costureros' => $request->costureros,
                'imagen' => $imageFilename,
                'imagen_alt' => $request->imagen_alt ?? $imageFilename,
                'fecha' => $request->fecha,
                'estado' => 0,
                'created_at' => now(),
            ]);
            
            Log::info('Corte creado exitosamente', [
                'corte_id' => $corte->id,
                'imagen' => $imageFilename,
                'colores' => $colores
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

    public function show(Corte $corte)
    {
        return view('sections.cortes-show', compact('corte'));
    }

    public function edit(Corte $corte)
    {
        return view('sections.cortes-edit-form', compact('corte'));
    }

    public function update(CorteRequest $request, Corte $corte)
    {
        try {
            Log::info('Actualizando corte', ['corte_id' => $corte->id, 'request' => $request->except(['imagen'])]);
            
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

            // Procesar colores JSON del formulario
            $colores = $this->processColoresFromForm($request->input('colores'));

            $corte->update([
                'numero_corte' => $request->numero_corte,
                'tipo_tela' => $request->tipo_tela,
                'colores' => $colores,
                'cantidad_total' => $request->cantidad_total,
                'articulos' => $request->articulos,
                'descripcion' => $request->descripcion,
                'costureros' => $request->costureros,
                'imagen' => $imageFilename,
                'imagen_alt' => $request->imagen_alt ?? $imageFilename,
                'estado' => $request->estado,
                'fecha' => $request->fecha,
                'updated_at' => now(),
            ]);
            
            Log::info('Corte actualizado exitosamente', [
                'corte_id' => $corte->id,
                'imagen' => $imageFilename,
                'colores' => $colores
            ]);
            
            return to_route('cortes.index')->with('success', 'Corte actualizado correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar corte', [
                'corte_id' => $corte->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['imagen'])
            ]);
            
            return to_route('cortes.index')->with('error', 'Error al actualizar el corte: ' . $e->getMessage());
        }
    }

    public function delete(Corte $corte)
    {
        try {
            Log::info('Eliminando corte', ['corte_id' => $corte->id]);
            
            // Eliminar imagen si no es la imagen por defecto
            if($corte->imagen !== self::DEFAULT_IMAGE) {
                $this->deleteImage($corte->imagen, self::IMAGE_DIRECTORY, self::DEFAULT_IMAGE);
            }
            
            $corte->delete();
            
            Log::info('Corte eliminado exitosamente', ['corte_id' => $corte->id]);
            return to_route('cortes.index')->with('success', 'Corte eliminado correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar corte', [
                'corte_id' => $corte->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return to_route('cortes.index')->with('error', 'Error al eliminar el corte: ' . $e->getMessage());
        }
    }

    /**
     * Procesar colores del formulario y convertirlos a formato JSON
     * Mantiene todas las entradas individuales sin combinar duplicados
     */
    private function processColoresFromForm($coloresData): array
    {
        $colores = [];
        
        if (is_array($coloresData) && isset($coloresData['color']) && isset($coloresData['cantidad'])) {
            $colors = $coloresData['color'];
            $cantidades = $coloresData['cantidad'];
            
            for ($i = 0; $i < count($colors); $i++) {
                $color = trim($colors[$i] ?? '');
                $cantidad = (int)($cantidades[$i] ?? 0);
                
                if (!empty($color) && $cantidad > 0) {
                    // Mantener cada entrada individual con un índice único
                    $colores[] = [
                        'color' => $color,
                        'cantidad' => $cantidad
                    ];
                }
            }
        }
        
        return $colores;
    }
}
