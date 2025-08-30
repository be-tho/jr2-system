@props([
    'route',
    'title' => 'Eliminar',
    'message' => '¿Estás seguro de que quieres eliminar este elemento?',
    'size' => 'md',
    'variant' => 'danger',
    'icon' => 'ri-delete-bin-line',
    'class' => '',
    'buttonClass' => '',
    'fullWidth' => false
])

@php
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
        ],
        'subtle-danger' => [
            'bg' => 'bg-red-50 dark:bg-red-900/20 hover:bg-red-100 dark:hover:bg-red-900/30',
            'text' => 'text-red-600 dark:text-red-400',
            'focus' => 'focus:ring-red-500'
        ]
    ];
    
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $variantClasses = $variants[$variant] ?? $variants['danger'];
    $isFullWidth = $fullWidth === true || $fullWidth === 'true';
    $widthClass = $isFullWidth ? 'w-full' : 'inline-flex';
@endphp

<form action="{{ $route }}" method="POST" class="delete-form {{ $class }}" data-confirm-message="{{ $message }}">
    @csrf
    @method('DELETE')
    
    <button 
        type="submit" 
        class="{{ $widthClass }} items-center justify-center {{ $sizeClass }} {{ $variantClasses['bg'] }} {{ $variantClasses['text'] }} rounded-lg transition-all duration-200 {{ $variantClasses['focus'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 dark:focus:ring-offset-gray-800 group {{ $buttonClass }}"
        data-confirm-message="{{ $message }}"
    >
        <i class="{{ $icon }} {{ $isFullWidth ? 'mr-2' : ($size === 'sm' ? 'text-sm' : 'mr-2') }} group-hover:scale-110 transition-transform duration-200"></i>
        @if($isFullWidth || $size !== 'sm')
            {{ $title }}
        @endif
    </button>
</form>

@once
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar formularios de eliminación con clase 'delete-form'
            const deleteForms = document.querySelectorAll('.delete-form');
            
            deleteForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevenir el envío inmediato
                    
                    // Obtener el mensaje de confirmación del formulario o del botón
                    const confirmMessage = form.dataset.confirmMessage || 
                                         form.querySelector('[data-confirm-message]')?.dataset.confirmMessage || 
                                         '¿Estás seguro de que quieres eliminar este elemento?';
                    
                    // Mostrar confirmación
                    if (confirm(confirmMessage)) {
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
                        
                        // Crear un nuevo formulario para evitar problemas con event listeners
                        const newForm = form.cloneNode(true);
                        newForm.style.display = 'none';
                        newForm.classList.remove('delete-form'); // Evitar que se vuelva a procesar
                        document.body.appendChild(newForm);
                        newForm.submit();
                    }
                    // Si se cancela, no hacer nada
                });
            });
        });
    </script>
    @endpush
@endonce
