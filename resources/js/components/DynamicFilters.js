// Componente Alpine.js para filtros dinámicos
export function DynamicFilters() {
    return {
        filters: {
            search: '',
            categoria_id: '',
            temporada_id: '',
            stock_min: '',
            stock_max: '',
            precio_min: '',
            precio_max: '',
            order_by: 'latest',
            order_direction: 'desc'
        },
        loading: false,
        results: [],
        pagination: {},
        
        init() {
            // Cargar filtros desde URL si existen
            this.loadFiltersFromURL();
            // Aplicar filtros iniciales
            this.applyFilters();
        },
        
        loadFiltersFromURL() {
            const urlParams = new URLSearchParams(window.location.search);
            Object.keys(this.filters).forEach(key => {
                if (urlParams.has(key)) {
                    this.filters[key] = urlParams.get(key);
                }
            });
        },
        
        updateURL() {
            const url = new URL(window.location);
            Object.keys(this.filters).forEach(key => {
                if (this.filters[key]) {
                    url.searchParams.set(key, this.filters[key]);
                } else {
                    url.searchParams.delete(key);
                }
            });
            window.history.replaceState({}, '', url);
        },
        
        async applyFilters() {
            this.loading = true;
            this.updateURL();
            
            try {
                const params = new URLSearchParams();
                Object.keys(this.filters).forEach(key => {
                    if (this.filters[key]) {
                        params.append(key, this.filters[key]);
                    }
                });
                
                const response = await fetch(`${window.location.pathname}?${params.toString()}`);
                const html = await response.text();
                
                // Actualizar solo el contenido de resultados
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newResults = doc.querySelector('[x-data*="results"]') || doc.querySelector('.results-container');
                
                if (newResults) {
                    const currentResults = document.querySelector('[x-data*="results"]') || document.querySelector('.results-container');
                    if (currentResults) {
                        currentResults.innerHTML = newResults.innerHTML;
                    }
                }
                
            } catch (error) {
                console.error('Error al aplicar filtros:', error);
            } finally {
                this.loading = false;
            }
        },
        
        clearFilters() {
            Object.keys(this.filters).forEach(key => {
                this.filters[key] = '';
            });
            this.filters.order_by = 'latest';
            this.filters.order_direction = 'desc';
            this.applyFilters();
        },
        
        debounce(func, wait) {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },
        
        // Aplicar filtros con debounce para búsqueda
        debouncedSearch: null,
        
        initDebouncedSearch() {
            this.debouncedSearch = this.debounce(() => {
                this.applyFilters();
            }, 300);
        }
    }
}
