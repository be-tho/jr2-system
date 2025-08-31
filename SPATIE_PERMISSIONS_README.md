# Sistema Simplificado de Roles con Spatie Laravel Permissions

## Resumen de Cambios

Se ha simplificado el sistema de roles usando **Spatie Laravel Permissions** con una configuración mínima y eficiente.

## Roles Configurados

### 1. **administrador**
- **Permisos completos**: Todos los permisos del sistema
- **Usuarios**: `beto@gmail.com`

### 2. **user**
- **Permisos de lectura**: Solo puede ver contenido
- **Usuarios**: `katy@jr2.com`, `judith@jr2.com`

## Permisos Disponibles

### Permisos Básicos (para usuarios regulares)
- `ver cortes`
- `ver articulos`
- `ver categorias`
- `ver temporadas`
- `ver reportes`
- `ver dolar`
- `ver dashboard`

### Permisos de Administrador
El rol `administrador` tiene acceso completo a todas las funcionalidades del sistema.

## Middleware Configurado

### `role`
- **Uso**: `role:administrador` o `role:user,administrador`
- **Descripción**: Verifica que el usuario tenga el rol específico

## Rutas Protegidas

### Rutas de Administrador (POST, PUT, DELETE)
```php
// Todas las rutas de administración están protegidas por rol
Route::middleware('role:administrador')->group(function () {
    Route::post('/cortes', [CorteController::class, 'store']);
    Route::put('/cortes/{corte}', [CorteController::class, 'update']);
    Route::delete('/cortes/{corte}', [CorteController::class, 'delete']);
    // etc...
});
```

### Rutas de Usuario (GET)
```php
// Usuarios regulares y administradores pueden ver
Route::middleware('role:user,administrador')->group(function () {
    Route::get('/cortes', [CorteController::class, 'index']);
    Route::get('/articulos', [ArticuloController::class, 'index']);
    // etc...
});
```

## Credenciales de Acceso

### Administrador
- **Email**: `beto@gmail.com`
- **Password**: `admin`

### Usuarios Regulares
- **Email**: `katy@jr2.com` / `judith@jr2.com`
- **Password**: `cuenca218`

## Métodos Disponibles en el Modelo User

```php
// Verificar roles
$user->hasRole('administrador');
$user->hasAnyRole(['administrador', 'user']);

// Verificar permisos
$user->hasPermissionTo('crear cortes');
$user->hasAnyPermission(['crear cortes', 'editar cortes']);

// Obtener roles y permisos
$user->roles; // Collection de roles
$user->permissions; // Collection de permisos directos
$user->getAllPermissions(); // Todos los permisos (directos + de roles)
```

## Métodos Disponibles

### En el Modelo User
```php
$user->hasRole('administrador'); // Verifica rol específico
$user->hasAnyRole(['administrador', 'user']); // Verifica múltiples roles
$user->roles; // Obtiene todos los roles del usuario
```

## Ventajas del Sistema Simplificado

1. **Simplicidad**: Configuración mínima y fácil de entender
2. **Eficiencia**: Solo los permisos necesarios están configurados
3. **Mantenibilidad**: Código limpio y sin redundancias
4. **Seguridad**: Verificación robusta de roles
5. **Escalabilidad**: Fácil agregar nuevos roles si es necesario

## Comandos Útiles

```bash
# Verificar roles
php artisan tinker
>>> $user = App\Models\User::find(1);
>>> $user->roles->pluck('name');

# Crear nuevo rol
php artisan tinker
>>> $role = Spatie\Permission\Models\Role::create(['name' => 'supervisor']);

# Asignar rol a usuario
php artisan tinker
>>> $user = App\Models\User::find(1);
>>> $user->assignRole('supervisor');
```
