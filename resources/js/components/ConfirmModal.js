// Componente Alpine.js para modal de confirmación
export function ConfirmModal() {
    return {
        show: false,
        title: '',
        message: '',
        init() {
            // Escuchar eventos para mostrar el modal
            window.addEventListener('show-confirmation-modal', (event) => {
                this.title = event.detail.title;
                this.message = event.detail.message;
                this.show = true;
            });
        },
        confirmar() {
            window.dispatchEvent(new CustomEvent('confirmation-accepted'));
            this.cerrar();
        },
        cerrar() {
            window.dispatchEvent(new CustomEvent('confirmation-cancelled'));
            this.show = false;
        }
    }
}

