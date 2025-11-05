{{-- Componente de notificaciones dinámicas con Alpine.js --}}
<div x-data="notifications()" class="fixed top-4 right-4 z-50 space-y-2 max-w-sm w-full px-4 sm:px-0">
    <template x-for="notification in notifications" :key="notification.id">
        <div 
            x-show="notification.show"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform translate-x-full scale-95"
            x-transition:enter-end="opacity-100 transform translate-x-0 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-x-0 scale-100"
            x-transition:leave-end="opacity-0 transform translate-x-full scale-95"
            class="w-full bg-white dark:bg-neutral-800 shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 dark:ring-neutral-700 overflow-hidden"
        >
            <div class="p-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div 
                            class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold"
                            :class="getColorClass(notification.type)"
                        >
                            <i :class="getIconClass(notification.type)" class="text-sm"></i>
                        </div>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.message"></p>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <button 
                            @click="remove(notification.id)"
                            class="bg-white dark:bg-neutral-800 rounded-md inline-flex text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none"
                        >
                            <span class="sr-only">Cerrar</span>
                            <i class="ri-close-line text-lg"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
