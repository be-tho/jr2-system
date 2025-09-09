<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticuloRequest;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Categoria;
use App\Models\Temporada;
use App\Repositories\ArticuloRepository;
use Illuminate\Support\Facades\Log;

class ArticuloController extends Controller
{
    use ImageHandler;

    protected $articuloRepository;

    // Configuración de imágenes para artículos
    private const IMAGE_DIRECTORY = 'src/assets/uploads/articulos';
    private const DEFAULT_IMAGE = 'default-articulo.svg';
    private const IMAGE_OPTIONS = [
        'width' => 500,
        'height' => 600,
        'quality' => 80,
        'format' => 'jpeg',
        'mobile_optimize' => true,
        'target_file_size' => 2048, // 2MB objetivo
    ];

    public function __construct(ArticuloRepository $articuloRepository)
    {
        $this->articuloRepository = $articuloRepository;
    }

    public function index(Request $request)
    {
        // Preparar filtros
        $filters = [
            'search' => $request->get('search'),
            'categoria_id' => $request->get('categoria_id'),
            'temporada_id' => $request->get('temporada_id'),
            'order_by' => $request->get('order_by', 'latest'),
            'order_direction' => $this->getOrderDirection($request->get('order_by', 'latest')),
        ];

        // Obtener artículos paginados con filtros
        $articulos = $this->articuloRepository->getPaginatedWithFilters($filters, $request->get('per_page', 12));

        // Obtener categorías y temporadas para los filtros (con caché)
        $categorias = cache()->remember('categorias_for_filters', 300, function () {
            return Categoria::select('id', 'nombre')->orderBy('nombre')->get();
        });
        
        $temporadas = cache()->remember('temporadas_for_filters', 300, function () {
            return Temporada::select('id', 'nombre')->orderBy('nombre')->get();
        });

        return view('sections.articulos', compact(
            'articulos',
            'categorias',
            'temporadas',
            'filters'
        ));
    }

    /**
     * Determinar la dirección del ordenamiento basado en el tipo de orden
     */
    private function getOrderDirection(string $orderBy): string
    {
        $ascendingOrders = ['nombre_asc', 'precio_asc', 'stock_asc', 'oldest'];
        return in_array($orderBy, $ascendingOrders) ? 'asc' : 'desc';
    }

    public function show($id)
    {
        $articulo = Articulo::with(['categoria:id,nombre', 'temporada:id,nombre'])->findOrFail($id);

        return view('sections.articulos-show', [
            'articulo' => $articulo,
        ]);
    }

    public function create()
    {
        // Obtener categorías y temporadas para el formulario (con caché)
        $categorias = cache()->remember('categorias_for_form', 300, function () {
            return Categoria::select('id', 'nombre')->orderBy('nombre')->get();
        });
        
        $temporadas = cache()->remember('temporadas_for_form', 300, function () {
            return Temporada::select('id', 'nombre')->orderBy('nombre')->get();
        });

        return view('sections.articulos-create', [
            'categorias' => $categorias,
            'temporadas' => $temporadas,
        ]);
    }

    public function store(ArticuloRequest $request)
    {
        try {
            Log::info('Creando nuevo artículo', ['request' => $request->except(['imagen', 'imagen_2', 'imagen_3'])]);
            
            $imageFilenames = [
                'imagen' => null,
                'imagen_2' => null,
                'imagen_3' => null,
            ];
            
            // Procesar imagen principal
            if($request->hasFile('imagen')) {
                $this->validateImage($request->file('imagen'));
                $imageFilenames['imagen'] = $this->processAndSaveImage(
                    $request->file('imagen'), 
                    self::IMAGE_DIRECTORY, 
                    self::IMAGE_OPTIONS
                );
            } else {
                $imageFilenames['imagen'] = self::DEFAULT_IMAGE;
            }

            // Procesar segunda imagen
            if($request->hasFile('imagen_2')) {
                $this->validateImage($request->file('imagen_2'));
                $imageFilenames['imagen_2'] = $this->processAndSaveImage(
                    $request->file('imagen_2'), 
                    self::IMAGE_DIRECTORY, 
                    self::IMAGE_OPTIONS
                );
            }

            // Procesar tercera imagen
            if($request->hasFile('imagen_3')) {
                $this->validateImage($request->file('imagen_3'));
                $imageFilenames['imagen_3'] = $this->processAndSaveImage(
                    $request->file('imagen_3'), 
                    self::IMAGE_DIRECTORY, 
                    self::IMAGE_OPTIONS
                );
            }

            $request->codigo = strtoupper($request->codigo);

            $articulo = Articulo::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'categoria_id' => $request->categoria_id,
                'temporada_id' => $request->temporada_id,
                'imagen' => $imageFilenames['imagen'],
                'imagen_2' => $imageFilenames['imagen_2'],
                'imagen_3' => $imageFilenames['imagen_3'],
                'stock' => $request->stock,
                'codigo' => $request->codigo,
                'created_at' => now(),
            ]);
            
            Log::info('Artículo creado exitosamente', [
                'articulo_id' => $articulo->id,
                'imagenes' => $imageFilenames
            ]);
            
            // Limpiar caché relacionado
            cache()->forget('categorias_for_filters');
            cache()->forget('categorias_for_form');
            cache()->forget('temporadas_for_filters');
            cache()->forget('temporadas_for_form');
            
            return to_route('articulos.index')->with('success', 'Artículo creado correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al crear artículo', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['imagen', 'imagen_2', 'imagen_3'])
            ]);
            
            return to_route('articulos.index')->with('error', 'Error al crear el artículo: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id);
        
        // Obtener categorías y temporadas para el formulario (con caché)
        $categorias = cache()->remember('categorias_for_form', 300, function () {
            return Categoria::select('id', 'nombre')->orderBy('nombre')->get();
        });
        
        $temporadas = cache()->remember('temporadas_for_form', 300, function () {
            return Temporada::select('id', 'nombre')->orderBy('nombre')->get();
        });

        return view('sections.articulos-edit-form', [
            'articulo' => $articulo,
            'categorias' => $categorias,
            'temporadas' => $temporadas,
        ]);
    }

    public function update(ArticuloRequest $request, $id)
    {
        try {
            Log::info('Actualizando artículo', ['articulo_id' => $id, 'request' => $request->except(['imagen', 'imagen_2', 'imagen_3'])]);
            
            $articulo = Articulo::findOrFail($id);
            $imageFilenames = [
                'imagen' => $articulo->imagen,
                'imagen_2' => $articulo->imagen_2,
                'imagen_3' => $articulo->imagen_3,
            ];
            
            // Procesar imagen principal
            if($request->hasFile('imagen')) {
                $this->validateImage($request->file('imagen'));
                $imageFilenames['imagen'] = $this->processAndSaveImage(
                    $request->file('imagen'), 
                    self::IMAGE_DIRECTORY, 
                    self::IMAGE_OPTIONS
                );
                
                // Eliminar imagen anterior si no es la imagen por defecto
                if($articulo->imagen !== self::DEFAULT_IMAGE) {
                    $this->deleteImage($articulo->imagen, self::IMAGE_DIRECTORY, self::DEFAULT_IMAGE);
                }
            }

            // Procesar segunda imagen
            if($request->hasFile('imagen_2')) {
                $this->validateImage($request->file('imagen_2'));
                $imageFilenames['imagen_2'] = $this->processAndSaveImage(
                    $request->file('imagen_2'), 
                    self::IMAGE_DIRECTORY, 
                    self::IMAGE_OPTIONS
                );
                
                // Eliminar imagen anterior si existe
                if($articulo->imagen_2) {
                    $this->deleteImage($articulo->imagen_2, self::IMAGE_DIRECTORY, self::DEFAULT_IMAGE);
                }
            }

            // Procesar tercera imagen
            if($request->hasFile('imagen_3')) {
                $this->validateImage($request->file('imagen_3'));
                $imageFilenames['imagen_3'] = $this->processAndSaveImage(
                    $request->file('imagen_3'), 
                    self::IMAGE_DIRECTORY, 
                    self::IMAGE_OPTIONS
                );
                
                // Eliminar imagen anterior si existe
                if($articulo->imagen_3) {
                    $this->deleteImage($articulo->imagen_3, self::IMAGE_DIRECTORY, self::DEFAULT_IMAGE);
                }
            }

            $request->codigo = strtoupper($request->codigo);

            $articulo->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'precio' => $request->precio,
                'categoria_id' => $request->categoria_id,
                'temporada_id' => $request->temporada_id,
                'imagen' => $imageFilenames['imagen'],
                'imagen_2' => $imageFilenames['imagen_2'],
                'imagen_3' => $imageFilenames['imagen_3'],
                'stock' => $request->stock,
                'codigo' => $request->codigo,
                'updated_at' => now(),
            ]);
            
            Log::info('Artículo actualizado exitosamente', [
                'articulo_id' => $articulo->id,
                'imagenes' => $imageFilenames
            ]);
            
            // Limpiar caché relacionado
            cache()->forget('categorias_for_filters');
            cache()->forget('categorias_for_form');
            cache()->forget('temporadas_for_filters');
            cache()->forget('temporadas_for_form');
            
            return to_route('articulos.index')->with('success', 'Artículo actualizado correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al actualizar artículo', [
                'articulo_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['imagen', 'imagen_2', 'imagen_3'])
            ]);
            
            return to_route('articulos.index')->with('error', 'Error al actualizar el artículo: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Log::info('Eliminando artículo', ['articulo_id' => $id]);
            
            $articulo = Articulo::findOrFail($id);
            
            // Eliminar todas las imágenes si no son la imagen por defecto
            $imagesToDelete = $articulo->getAllImages();
            foreach ($imagesToDelete as $image) {
                if ($image !== self::DEFAULT_IMAGE) {
                    $this->deleteImage($image, self::IMAGE_DIRECTORY, self::DEFAULT_IMAGE);
                }
            }
            
            $articulo->delete();
            
            Log::info('Artículo eliminado exitosamente', ['articulo_id' => $id]);
            
            // Limpiar caché relacionado
            cache()->forget('categorias_for_filters');
            cache()->forget('categorias_for_form');
            cache()->forget('temporadas_for_filters');
            cache()->forget('temporadas_for_form');
            
            return to_route('articulos.index')->with('success', 'Artículo eliminado correctamente');
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar artículo', [
                'articulo_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return to_route('articulos.index')->with('error', 'Error al eliminar el artículo: ' . $e->getMessage());
        }
    }
}
