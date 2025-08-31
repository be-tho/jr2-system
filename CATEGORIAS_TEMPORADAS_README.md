# Sistema de Categorías y Temporadas

Este documento describe el nuevo sistema de gestión de categorías y temporadas implementado en JR2 System.

## Características

### Categorías
- **CRUD completo**: Crear, leer, actualizar y eliminar categorías
- **Validación**: Nombres únicos y obligatorios
- **Relaciones**: Conteo automático de artículos asociados
- **Seguridad**: No se pueden eliminar categorías con artículos asociados

### Temporadas
- **CRUD completo**: Crear, leer, actualizar y eliminar temporadas
- **Validación**: Nombres únicos y obligatorios
- **Relaciones**: Conteo automático de artículos asociados
- **Seguridad**: No se pueden eliminar temporadas con artículos asociados

## Estructura de Archivos

### Controladores
- `app/Http/Controllers/CategoriaController.php` - Gestión de categorías
- `app/Http/Controllers/TemporadaController.php` - Gestión de temporadas

### Modelos
- `app/Models/Categoria.php` - Modelo de categoría con relaciones
- `app/Models/Temporada.php` - Modelo de temporada con relaciones

### Vistas
- `resources/views/sections/categorias/` - Vistas para categorías
  - `index.blade.php` - Lista de categorías
  - `create.blade.php` - Formulario de creación
  - `edit.blade.php` - Formulario de edición
- `resources/views/sections/temporadas/` - Vistas para temporadas
  - `index.blade.php` - Lista de temporadas
  - `create.blade.php` - Formulario de creación
  - `edit.blade.php` - Formulario de edición

### Rutas
```php
// Categorías
Route::prefix('categorias')->name('categorias.')->group(function () {
    Route::get('/', [CategoriaController::class, 'index'])->name('index');
    Route::get('/create', [CategoriaController::class, 'create'])->name('create');
    Route::post('/', [CategoriaController::class, 'store'])->name('store');
    Route::get('/{categoria}/edit', [CategoriaController::class, 'edit'])->name('edit');
    Route::put('/{categoria}', [CategoriaController::class, 'update'])->name('update');
    Route::delete('/{categoria}', [CategoriaController::class, 'destroy'])->name('destroy');
});

// Temporadas
Route::prefix('temporadas')->name('temporadas.')->group(function () {
    Route::get('/', [TemporadaController::class, 'index'])->name('index');
    Route::get('/create', [TemporadaController::class, 'create'])->name('create');
    Route::post('/', [TemporadaController::class, 'store'])->name('store');
    Route::get('/{temporada}/edit', [TemporadaController::class, 'edit'])->name('edit');
    Route::put('/{temporada}', [TemporadaController::class, 'update'])->name('update');
    Route::delete('/{temporada}', [TemporadaController::class, 'destroy'])->name('destroy');
});
```

## Navegación

Se han agregado nuevos enlaces en la barra de navegación:
- **Categorías**: Icono de etiqueta de precio (`ri-price-tag-3-line`)
- **Temporadas**: Icono de calendario (`ri-calendar-line`)

## Funcionalidades

### Listado (Index)
- Tabla responsive con información detallada
- Paginación automática (15 elementos por página)
- Conteo de artículos asociados
- Acciones de editar y eliminar
- Estado vacío con call-to-action

### Creación (Create)
- Formulario simple con validación
- Consejos y mejores prácticas
- Navegación de regreso al listado
- Validación del lado del servidor

### Edición (Edit)
- Formulario pre-poblado con datos existentes
- Información del sistema (ID, fechas)
- Advertencias sobre cambios
- Validación de unicidad

### Eliminación (Delete)
- Confirmación antes de eliminar
- Verificación de artículos asociados
- Prevención de eliminación si hay dependencias
- Mensajes de error informativos

## Validaciones

### Categorías
- `nombre`: Requerido, string, máximo 255 caracteres, único en la tabla

### Temporadas
- `nombre`: Requerido, string, máximo 255 caracteres, único en la tabla

## Relaciones

### Categoria
```php
public function articulos()
{
    return $this->hasMany(Articulo::class, 'categoria_id');
}
```

### Temporada
```php
public function articulos()
{
    return $this->hasMany(Articulo::class, 'temporada_id');
}
```

### Articulo
```php
public function categoria(): BelongsTo
{
    return $this->belongsTo(Categoria::class, 'categoria_id');
}

public function temporada(): BelongsTo
{
    return $this->belongsTo(Temporada::class, 'temporada_id');
}
```

## Diseño

El sistema mantiene la consistencia visual con el resto de la aplicación:
- **Colores**: Paleta primaria con fucsia (`primary-600`, `primary-700`)
- **Tipografía**: Sistema de fuentes consistente
- **Componentes**: Botones, formularios y tablas estandarizados
- **Responsive**: Diseño adaptable a diferentes tamaños de pantalla
- **Dark Mode**: Soporte completo para tema oscuro

## Seguridad

- **Middleware de autenticación**: Todas las rutas requieren login
- **Validación de entrada**: Sanitización y validación de datos
- **Prevención de eliminación**: Verificación de dependencias
- **Logging**: Registro de operaciones para auditoría

## Uso

### Acceso
1. Iniciar sesión en el sistema
2. Usar los enlaces de navegación para acceder a Categorías o Temporadas
3. Navegar entre las diferentes vistas según la operación deseada

### Crear Nueva Categoría/Temporada
1. Hacer clic en "Nueva Categoría" o "Nueva Temporada"
2. Completar el formulario con el nombre
3. Hacer clic en "Crear" para guardar

### Editar Existente
1. Hacer clic en el icono de editar en la tabla
2. Modificar el nombre en el formulario
3. Hacer clic en "Actualizar" para guardar cambios

### Eliminar
1. Hacer clic en el icono de eliminar en la tabla
2. Confirmar la acción en el diálogo
3. El sistema verificará dependencias antes de eliminar

## Mantenimiento

### Base de Datos
- Las tablas `categoria` y `temporada` ya existen con la estructura correcta
- Los timestamps están habilitados para auditoría
- Las relaciones están correctamente configuradas

### Código
- Los controladores siguen las convenciones de Laravel
- Los modelos incluyen relaciones y scopes útiles
- Las vistas usan componentes Blade reutilizables

## Futuras Mejoras

- **Búsqueda y filtros**: Agregar funcionalidad de búsqueda en listados
- **Ordenamiento**: Permitir ordenar por diferentes campos
- **Importación/Exportación**: Funcionalidades de bulk operations
- **Historial de cambios**: Auditoría detallada de modificaciones
- **Categorías anidadas**: Soporte para subcategorías
- **Temporadas con fechas**: Agregar fechas de inicio y fin
