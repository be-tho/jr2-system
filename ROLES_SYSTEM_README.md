# Sistema de Roles - JR2 System

## Descripción
Este documento describe el sistema de roles implementado en JR2 System, que permite controlar el acceso a diferentes funcionalidades del sistema basándose en el rol del usuario.

## Roles Disponibles

### 1. Administrador (`admin`)
- **Acceso completo** a todas las funcionalidades del sistema
- **Gestión completa** de cortes, artículos, categorías y temporadas
- **Acceso a reportes** y estadísticas
- **Gestión de tasas de cambio** del dólar
- **Usuario asignado**: `beto@gmail.com`

### 2. Usuario (`user`)
- **Acceso limitado** a funcionalidades básicas
- **Dashboard principal** y estadísticas básicas
- **Gestión de cuenta personal**
- **Sin acceso** a funciones administrativas

## Implementación Técnica

### Middlewares
- `admin`: Verifica que el usuario sea administrador
- `role`: Verifica que el usuario tenga un rol específico o múltiples roles

### Uso en Rutas
```php
// Solo administradores
Route::middleware('admin')->group(function () {
    // Rutas administrativas
});

// Múltiples roles
Route::middleware('role:admin,user')->group(function () {
    // Rutas accesibles para ambos roles
});
```

### Verificación en Vistas
```php
@if(AuthHelper::isAdmin())
    <!-- Contenido solo para administradores -->
@endif

@if(AuthHelper::hasRole('admin'))
    <!-- Contenido para administradores -->
@endif
```

### Verificación en Controladores
```php
if (auth()->user()->isAdmin()) {
    // Lógica para administradores
}

if (auth()->user()->hasRole('admin')) {
    // Lógica para administradores
}
```

## Estructura de Base de Datos

### Tabla `users`
- `id`: Identificador único
- `name`: Nombre del usuario
- `email`: Correo electrónico (único)
- `role`: Rol del usuario (`admin` o `user`)
- `password`: Contraseña encriptada
- `profile_image`: Imagen de perfil
- `created_at`: Fecha de creación
- `updated_at`: Fecha de última actualización

## Migraciones

### Nueva migración creada:
- `2024_12_19_140000_add_role_to_users_table.php`: Agrega el campo `role` a la tabla `users`

## Seeders

### Seeders actualizados:
- `UserSeeder`: Crea usuarios con roles específicos
- `UpdateUsersRoleSeeder`: Actualiza usuarios existentes con roles por defecto
- `DatabaseSeeder`: Incluye todos los seeders necesarios

## Seguridad

### Características de Seguridad:
- **Middleware de autenticación** en todas las rutas protegidas
- **Verificación de roles** antes de permitir acceso a funcionalidades
- **Fallback seguro** para usuarios no autenticados
- **Manejo de errores 403** para accesos no autorizados

### Buenas Prácticas:
- Siempre verificar roles en el backend, no solo en el frontend
- Usar middlewares para control de acceso a nivel de ruta
- Implementar logging para auditoría de accesos
- Validar permisos en cada operación crítica

## Uso del Sistema

### Para Desarrolladores:
1. **Agregar nuevas funcionalidades**: Usar middlewares `admin` o `role` según corresponda
2. **Verificar permisos**: Usar métodos del modelo User o AuthHelper
3. **Crear nuevos roles**: Modificar la migración y el modelo User

### Para Administradores:
1. **Acceso completo** al sistema
2. **Gestión de usuarios** (futura implementación)
3. **Configuración del sistema**

### Para Usuarios:
1. **Acceso limitado** a funcionalidades básicas
2. **Sin acceso** a funciones administrativas
3. **Gestión de cuenta personal**

## Mantenimiento

### Comandos Útiles:
```bash
# Ejecutar migraciones
php artisan migrate

# Ejecutar seeders
php artisan db:seed

# Ejecutar seeder específico
php artisan db:seed --class=UpdateUsersRoleSeeder

# Limpiar caché de autoload
composer dump-autoload
```

### Monitoreo:
- Revisar logs de Laravel para accesos no autorizados
- Verificar que los middlewares estén funcionando correctamente
- Monitorear el uso de funcionalidades por rol

## Futuras Mejoras

### Funcionalidades Planificadas:
- **Gestión de usuarios** para administradores
- **Sistema de permisos granulares** (CRUD por entidad)
- **Auditoría de accesos** y cambios
- **Roles personalizados** con permisos específicos
- **Interfaz de administración** de roles y permisos

### Consideraciones Técnicas:
- **Cache de permisos** para mejor rendimiento
- **API de roles** para aplicaciones frontend
- **Sincronización** con sistemas externos de autenticación
