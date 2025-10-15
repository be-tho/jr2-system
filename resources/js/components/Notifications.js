// Componente Alpine.js para notificaciones dinámicas
export function Notifications() {
    return {
        notifications: [],
        
        init() {
            // Escuchar eventos de notificaciones
            window.addEventListener('show-notification', (event) => {
                this.show(event.detail);
            });
            
            // Mostrar notificaciones existentes de Laravel
            this.showExistingNotifications();
        },
        
        showExistingNotifications() {
            // Buscar mensajes de sesión de Laravel
            const successMessage = document.querySelector('.alert-success');
            const errorMessage = document.querySelector('.alert-danger');
            const warningMessage = document.querySelector('.alert-warning');
            const infoMessage = document.querySelector('.alert-info');
            
            if (successMessage) {
                this.show({
                    type: 'success',
                    message: successMessage.textContent.trim(),
                    duration: 5000
                });
            }
            
            if (errorMessage) {
                this.show({
                    type: 'error',
                    message: errorMessage.textContent.trim(),
                    duration: 8000
                });
            }
            
            if (warningMessage) {
                this.show({
                    type: 'warning',
                    message: warningMessage.textContent.trim(),
                    duration: 6000
                });
            }
            
            if (infoMessage) {
                this.show({
                    type: 'info',
                    message: infoMessage.textContent.trim(),
                    duration: 5000
                });
            }
        },
        
        show(notification) {
            const id = Date.now();
            const newNotification = {
                id: id,
                type: notification.type || 'info',
                message: notification.message,
                duration: notification.duration || 5000,
                show: true
            };
            
            this.notifications.push(newNotification);
            
            // Auto-remover después de la duración especificada
            if (newNotification.duration > 0) {
                setTimeout(() => {
                    this.remove(id);
                }, newNotification.duration);
            }
        },
        
        remove(id) {
            const index = this.notifications.findIndex(n => n.id === id);
            if (index > -1) {
                this.notifications[index].show = false;
                setTimeout(() => {
                    this.notifications.splice(index, 1);
                }, 300); // Tiempo para la animación de salida
            }
        },
        
        removeAll() {
            this.notifications.forEach(notification => {
                notification.show = false;
            });
            setTimeout(() => {
                this.notifications = [];
            }, 300);
        },
        
        getIcon(type) {
            const icons = {
                success: '✓',
                error: '✗',
                warning: '⚠',
                info: 'ℹ'
            };
            return icons[type] || icons.info;
        },
        
        getColorClass(type) {
            const colors = {
                success: 'bg-green-500',
                error: 'bg-red-500',
                warning: 'bg-yellow-500',
                info: 'bg-blue-500'
            };
            return colors[type] || colors.info;
        }
    }
}

// Función helper para mostrar notificaciones desde cualquier parte del código
window.showNotification = function(type, message, duration = 5000) {
    window.dispatchEvent(new CustomEvent('show-notification', {
        detail: { type, message, duration }
    }));
};
