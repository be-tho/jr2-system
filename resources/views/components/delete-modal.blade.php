@props([
    'route',
    'title' => 'Eliminar',
    'triggerText' => 'Eliminar',
    'modalTitle' => 'Confirmar eliminación',
    'modalMessage' => '¿Estás seguro de que quieres eliminar este elemento?',
    'modalDescription' => 'Esta acción no se puede deshacer.',
    'confirmText' => 'Sí, eliminar',
    'cancelText' => 'Cancelar',
    'size' => 'md',
    'variant' => 'danger',
    'icon' => 'ri-delete-bin-line',
    'triggerClass' => '',
    'fullWidth' => false,
    'itemName' => 'elemento',
    'modalId' => null
])

@php
    $modalId = $modalId ?? 'delete-modal-' . uniqid();
    
    // Definir tamaños
    $sizes = [
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-3 text-sm font-medium',
        'lg' => 'px-6 py-4 text-base font-medium'
    ];
    
    // Definir variantes de color
    $variants = [
        'danger' => [
            'bg' => 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700',
            'text' => 'text-white',
            'focus' => 'focus:ring-red-500'
        ],
        'outline-danger' => [
            'bg' => 'bg-transparent hover:bg-red-50 dark:hover:bg-red-900/20 border border-red-500 dark:border-red-400',
            'text' => 'text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300',
            'focus' => 'focus:ring-red-500'
        ]
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClasses = $variants[$variant] ?? $variants['danger'];
    $widthClass = filter_var($fullWidth, FILTER_VALIDATE_BOOLEAN) ? 'w-full' : 'inline-flex';
@endphp

{{-- Botón trigger --}}
<button 
    type="button"
    class="{{ $widthClass }} items-center justify-center {{ $sizeClass }} {{ $variantClasses['bg'] }} {{ $variantClasses['text'] }} rounded-lg transition-all duration-200 {{ $variantClasses['focus'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 group {{ $triggerClass }}"
    onclick="openDeleteModal('{{ $modalId }}')"
>
    <i class="{{ $icon }} {{ filter_var($fullWidth, FILTER_VALIDATE_BOOLEAN) ? 'mr-2' : ($size === 'sm' ? 'text-sm' : 'mr-2') }} group-hover:scale-110 transition-transform duration-200"></i>
    @if(filter_var($fullWidth, FILTER_VALIDATE_BOOLEAN) || $size !== 'sm')
        {{ $triggerText }}
    @endif
</button>

{{-- Modal --}}
<div id="{{ $modalId }}" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4" onclick="closeDeleteModal('{{ $modalId }}')">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-2xl border border-neutral-200 dark:border-neutral-700 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" onclick="event.stopPropagation()">
        {{-- Header --}}
        <div class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-700">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                    <i class="ri-alert-line text-red-600 dark:text-red-400 text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">
                        {{ $modalTitle }}
                    </h3>
                    <p class="text-sm text-neutral-600 dark:text-neutral-400">
                        {{ $modalDescription }}
                    </p>
                </div>
            </div>
        </div>
        
        {{-- Content --}}
        <div class="px-6 py-4">
            <p class="text-neutral-700 dark:text-neutral-300">
                {{ $modalMessage }}
            </p>
        </div>
        
        {{-- Actions --}}
        <div class="px-6 py-4 border-t border-neutral-200 dark:border-neutral-700 flex items-center justify-end space-x-3">
            <button 
                type="button"
                class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-neutral-100 dark:bg-neutral-700 hover:bg-neutral-200 dark:hover:bg-neutral-600 rounded-lg transition-colors duration-200"
                onclick="closeDeleteModal('{{ $modalId }}')"
            >
                {{ $cancelText }}
            </button>
            
            <form action="{{ $route }}" method="POST" class="inline" id="delete-form-{{ $modalId }}">
                @csrf
                @method('DELETE')
                <button 
                    type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 rounded-lg transition-all duration-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-neutral-800"
                >
                    {{ $confirmText }}
                </button>
            </form>
        </div>
    </div>
</div>

@once
    @push('scripts')
    <script>
        function openDeleteModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('div[onclick="event.stopPropagation()"]');
            
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Animar la aparición
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }
        
        function closeDeleteModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('div[onclick="event.stopPropagation()"]');
            
            // Animar la desaparición
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }, 300);
        }
        
        // Cerrar modal con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const visibleModals = document.querySelectorAll('[id^="delete-modal-"]:not(.hidden)');
                visibleModals.forEach(modal => {
                    const modalId = modal.id;
                    closeDeleteModal(modalId);
                });
            }
        });
        
        // Manejar envío de formularios de eliminación en modales
        document.addEventListener('DOMContentLoaded', function() {
            const deleteForms = document.querySelectorAll('[id^="delete-form-"]');
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    // Mostrar loading si la función existe
                    if (typeof window.showLoading === 'function') {
                        window.showLoading();
                    }
                    
                    // Deshabilitar el botón para evitar doble envío
                    const submitBtn = form.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<i class="ri-loader-4-line animate-spin mr-2"></i>Eliminando...';
                    }
                });
            });
        });
    </script>
    @endpush
@endonce
