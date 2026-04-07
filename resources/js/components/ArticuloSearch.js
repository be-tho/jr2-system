// Componente Alpine.js para búsqueda de artículos en ventas
export function ArticuloSearch() {
    return {
        searchTerm: '',
        articulos: [],
        loading: false,
        selectedArticulo: null,
        showDropdown: false,
        
        init() {
            // Cargar artículos iniciales
            this.loadArticulos();
        },
        
        async loadArticulos() {
            this.loading = true;
            try {
                const response = await fetch(`/ventas/search-articulos?q=${encodeURIComponent(this.searchTerm)}`);
                const data = await response.json();
                this.articulos = data;
                this.showDropdown = data.length > 0;
            } catch (error) {
                console.error('Error al cargar artículos:', error);
                this.articulos = [];
                this.showDropdown = false;
            } finally {
                this.loading = false;
            }
        },
        
        selectArticulo(articulo) {
            this.selectedArticulo = articulo;
            this.searchTerm = articulo.nombre;
            this.showDropdown = false;
            
            // Emitir evento para que el componente padre pueda usar el artículo seleccionado
            this.$dispatch('articulo-selected', articulo);
        },
        
        clearSelection() {
            this.selectedArticulo = null;
            this.searchTerm = '';
            this.showDropdown = false;
            this.$dispatch('articulo-cleared');
        },
        
        onSearchInput() {
            if (this.searchTerm.length >= 1) {
                this.loadArticulos();
            } else {
                this.articulos = [];
                this.showDropdown = false;
            }
        },
        
        hideDropdown() {
            // Ocultar dropdown después de un pequeño delay para permitir clicks
            setTimeout(() => {
                this.showDropdown = false;
            }, 200);
        }
    }
}
