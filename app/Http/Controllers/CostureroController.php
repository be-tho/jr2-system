<?php

namespace App\Http\Controllers;

use App\Http\Requests\CostureroRequest;
use Illuminate\Http\Request;
use App\Models\Costurero;
use App\Repositories\CostureroRepository;
use Illuminate\Support\Facades\Log;

class CostureroController extends Controller
{
    protected $costureroRepository;

    public function __construct(CostureroRepository $costureroRepository)
    {
        $this->costureroRepository = $costureroRepository;
    }

    public function index(Request $request)
    {
        // Preparar filtros
        $filters = [
            'search' => $request->get('search'),
            'order_by' => $request->get('order_by', 'latest'),
            'order_direction' => $this->getOrderDirection($request->get('order_by', 'latest')),
        ];

        // Obtener costureros paginados con filtros
        $costureros = $this->costureroRepository->getPaginatedWithFilters($filters, $request->get('per_page', 12));

        return view('sections.costureros', compact('costureros', 'filters'));
    }

    /**
     * Determinar la dirección del ordenamiento basado en el tipo de orden
     */
    private function getOrderDirection(string $orderBy): string
    {
        $ascendingOrders = ['nombre_asc', 'oldest'];
        return in_array($orderBy, $ascendingOrders) ? 'asc' : 'desc';
    }

    public function show($id)
    {
        $costurero = Costurero::findOrFail($id);

        return view('sections.costureros-show', [
            'costurero' => $costurero,
        ]);
    }

    public function create()
    {
        return view('sections.costureros-create');
    }

    public function store(CostureroRequest $request)
    {
        try {
            Log::info('Creando nuevo costurero', ['request' => $request->validated()]);
            
            $costurero = Costurero::create($request->validated());

            return redirect()
                ->route('costureros.show', $costurero)
                ->with('success', 'Costurero creado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al crear costurero', [
                'error' => $e->getMessage(),
                'request' => $request->validated()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Error al crear el costurero. Por favor, inténtalo de nuevo.');
        }
    }

    public function edit($id)
    {
        $costurero = Costurero::findOrFail($id);

        return view('sections.costureros-edit', [
            'costurero' => $costurero,
        ]);
    }

    public function update(CostureroRequest $request, $id)
    {
        try {
            $costurero = Costurero::findOrFail($id);
            
            Log::info('Actualizando costurero', [
                'id' => $id,
                'request' => $request->validated()
            ]);

            $costurero->update($request->validated());

            return redirect()
                ->route('costureros.show', $costurero)
                ->with('success', 'Costurero actualizado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al actualizar costurero', [
                'id' => $id,
                'error' => $e->getMessage(),
                'request' => $request->validated()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Error al actualizar el costurero. Por favor, inténtalo de nuevo.');
        }
    }

    public function destroy($id)
    {
        try {
            $costurero = Costurero::findOrFail($id);
            
            Log::info('Eliminando costurero', ['id' => $id]);

            $costurero->delete();

            return redirect()
                ->route('costureros.index')
                ->with('success', 'Costurero eliminado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al eliminar costurero', [
                'id' => $id,
                'error' => $e->getMessage()
            ]);

            return back()
                ->with('error', 'Error al eliminar el costurero. Por favor, inténtalo de nuevo.');
        }
    }
}
