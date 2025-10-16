// Componente Alpine.js para formulario de ventas
export function VentaForm() {
    return {
        items: [],
        clienteNombre: '',
        notas: '',
        total: 0,
        submitting: false,
        
        init() {
            // Agregar el primer item vacío
            this.addItem();
        },
        
        addItem() {
            this.items.push({
                id: Date.now(),
                articulo_id: '',
                articulo_nombre: '',
                cantidad: 1,
                precio_unitario: 0,
                subtotal: 0,
                detalle: ''
            });
        },
        
        removeItem(index) {
            this.items.splice(index, 1);
            this.calculateTotal();
        },
        
        onArticuloSelected(itemIndex, articulo) {
            const item = this.items[itemIndex];
            item.articulo_id = articulo.id;
            item.articulo_nombre = articulo.nombre;
            item.precio_unitario = articulo.precio;
            item.cantidad = 1; // Reset cantidad
            this.calculateSubtotal(itemIndex);
        },
        
        calculateSubtotal(index) {
            const item = this.items[index];
            item.subtotal = item.cantidad * item.precio_unitario;
            this.calculateTotal();
        },
        
        calculateTotal() {
            this.total = this.items.reduce((sum, item) => sum + item.subtotal, 0);
        },
        
        validateForm() {
            // Validar que hay al menos un item
            if (this.items.length === 0) {
                alert('Debe agregar al menos un artículo a la venta.');
                return false;
            }
            
            // Validar que todos los items tienen artículo seleccionado
            for (let i = 0; i < this.items.length; i++) {
                const item = this.items[i];
                if (!item.articulo_id) {
                    alert(`El item ${i + 1} debe tener un artículo seleccionado.`);
                    return false;
                }
                if (item.cantidad <= 0) {
                    alert(`La cantidad del item ${i + 1} debe ser mayor a 0.`);
                    return false;
                }
            }
            
            return true;
        },
        
        async submitForm() {
            if (!this.validateForm()) {
                return;
            }
            
            this.submitting = true;
            
            try {
                const formData = {
                    cliente_nombre: this.clienteNombre,
                    notas: this.notas,
                    items: this.items.map(item => ({
                        articulo_id: item.articulo_id,
                        cantidad: item.cantidad,
                        precio_unitario: item.precio_unitario,
                        detalle: item.detalle
                    }))
                };
                
                const response = await fetch('/ventas', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                });
                
                if (response.ok) {
                    const result = await response.json();
                    window.location.href = `/ventas/${result.venta_id}`;
                } else {
                    const error = await response.json();
                    alert('Error al crear la venta: ' + (error.message || 'Error desconocido'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al crear la venta. Por favor, intente nuevamente.');
            } finally {
                this.submitting = false;
            }
        },
        
        formatPrice(price) {
            return new Intl.NumberFormat('es-AR', {
                style: 'currency',
                currency: 'ARS'
            }).format(price);
        }
    }
}
