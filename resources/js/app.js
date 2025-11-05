import './bootstrap';
import Alpine from 'alpinejs';

// Importar componentes Alpine.js
import { ArticuloSearch } from './components/ArticuloSearch.js';
import { VentaForm } from './components/VentaForm.js';
import { DynamicFilters } from './components/DynamicFilters.js';
import { Notifications } from './components/Notifications.js';
import { ConfirmModal } from './components/ConfirmModal.js';

// Registrar componentes globalmente
Alpine.data('articuloSearch', ArticuloSearch);
Alpine.data('ventaForm', VentaForm);
Alpine.data('dynamicFilters', DynamicFilters);
Alpine.data('notifications', Notifications);
Alpine.data('confirmModal', ConfirmModal);

// Inicializar Alpine.js
window.Alpine = Alpine;
Alpine.start();
