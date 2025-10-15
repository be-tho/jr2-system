{{-- Componente de formulario de ventas con Alpine.js --}}
<div x-data="ventaForm()" class="max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6">Nueva Venta</h2>
    
    {{-- Información del cliente --}}
    <div class="mb-6">
        <label for="cliente_nombre" class="block text-sm font-medium text-gray-700 mb-2">
            Cliente
        </label>
        <input 
            type="text" 
            id="cliente_nombre" 
            x-model="clienteNombre"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Nombre del cliente (opcional)"
        >
    </div>
    
    {{-- Items de la venta --}}
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Artículos</h3>
            <button 
                @click="addItem()" 
                type="button"
                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors"
            >
                + Agregar Artículo
            </button>
        </div>
        
        <div class="space-y-4">
            <template x-for="(item, index) in items" :key="item.id">
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex justify-between items-start mb-4">
                        <h4 class="font-medium" x-text="`Artículo ${index + 1}`"></h4>
                        <button 
                            @click="removeItem(index)" 
                            type="button"
                            class="text-red-500 hover:text-red-700"
                            x-show="items.length > 1"
                        >
                            ✕
                        </button>
                    </div>
                    
                    {{-- Búsqueda de artículo --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Artículo
                        </label>
                        <div x-data="articuloSearch()" @articulo-selected="onArticuloSelected(index, $event.detail)">
                            <input 
                                type="text" 
                                x-model="searchTerm"
                                @input="onSearchInput()"
                                @blur="hideDropdown()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Buscar artículo..."
                            >
                            
                            {{-- Dropdown de resultados --}}
                            <div 
                                x-show="showDropdown" 
                                class="absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto"
                            >
                                <template x-for="articulo in articulos" :key="articulo.id">
                                    <div 
                                        @click="selectArticulo(articulo)"
                                        class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0"
                                    >
                                        <div class="font-medium" x-text="articulo.nombre"></div>
                                        <div class="text-sm text-gray-600">
                                            Código: <span x-text="articulo.codigo"></span> | 
                                            Stock: <span x-text="articulo.stock"></span> | 
                                            Precio: <span x-text="articulo.precio_formateado"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Cantidad y precio --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Cantidad
                            </label>
                            <input 
                                type="number" 
                                x-model="item.cantidad"
                                @input="calculateSubtotal(index)"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Precio Unitario
                            </label>
                            <input 
                                type="number" 
                                x-model="item.precio_unitario"
                                @input="calculateSubtotal(index)"
                                step="0.01"
                                min="0"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            >
                        </div>
                    </div>
                    
                    {{-- Detalle --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Detalle (opcional)
                        </label>
                        <input 
                            type="text" 
                            x-model="item.detalle"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Detalle adicional del artículo"
                        >
                    </div>
                    
                    {{-- Subtotal --}}
                    <div class="text-right">
                        <span class="text-sm text-gray-600">Subtotal: </span>
                        <span class="font-semibold" x-text="formatPrice(item.subtotal)"></span>
                    </div>
                </div>
            </template>
        </div>
    </div>
    
    {{-- Notas --}}
    <div class="mb-6">
        <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">
            Notas
        </label>
        <textarea 
            id="notas" 
            x-model="notas"
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Notas adicionales de la venta"
        ></textarea>
    </div>
    
    {{-- Total --}}
    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
        <div class="flex justify-between items-center">
            <span class="text-lg font-semibold">Total:</span>
            <span class="text-2xl font-bold text-green-600" x-text="formatPrice(total)"></span>
        </div>
    </div>
    
    {{-- Botones --}}
    <div class="flex justify-end space-x-4">
        <a 
            href="/ventas" 
            class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors"
        >
            Cancelar
        </a>
        <button 
            @click="submitForm()" 
            :disabled="submitting || total <= 0"
            class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 disabled:bg-gray-400 disabled:cursor-not-allowed transition-colors"
        >
            <span x-show="!submitting">Crear Venta</span>
            <span x-show="submitting">Creando...</span>
        </button>
    </div>
</div>
