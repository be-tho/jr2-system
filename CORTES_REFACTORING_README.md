# Refactorización de la Tabla de Cortes

## Descripción

Se ha refactorizado la tabla de cortes para incluir nuevos campos y mejorar la estructura de datos. Los cambios principales incluyen:

### Nuevos Campos Agregados

1. **`tipo_tela`** (string) - Tipo de tela utilizada en el corte
2. **`cantidad_encimadas`** (integer) - Cantidad de encimadas del corte
3. **`colores`** (json) - Colores con sus cantidades en formato JSON flexible
4. **`cantidad_total`** (integer) - Cantidad total de artículos (renombrado desde `cantidad`)
5. **`descripcion`** (string) - Descripción del corte (renombrado desde `nombre`)

### Estructura de Colores JSON

El campo `colores` ahora es de tipo JSON y permite almacenar colores con cantidades de forma flexible:

```json
{
    "rojo": 23,
    "amarillo": 15,
    "azul": 8,
    "verde": 12
}
```

Esto permite:
- Agregar cualquier cantidad de colores
- Asignar cantidades específicas a cada color
- Flexibilidad total en la estructura de datos

### Campos Mantenidos

- `id` - Identificador único
- `numero_corte` - Número de corte
- `articulos` - Artículos del corte
- `costureros` - Costureros asignados
- `estado` - Estado del corte (0: Cortado, 1: Costurando, 2: Entregado)
- `imagen` - Imagen del corte
- `imagen_alt` - Texto alternativo de la imagen
- `fecha` - Fecha del corte
- `created_at` y `updated_at` - Timestamps

## Instrucciones de Migración

### 1. Ejecutar Migración de Datos

Primero, migrar los datos existentes a la nueva estructura:

```bash
php artisan cortes:migrate-data
```

### 2. Ejecutar Migración de Base de Datos

Luego, ejecutar la migración para modificar la tabla:

```bash
php artisan migrate
```

### 3. Verificar la Migración

Verificar que todos los datos se migraron correctamente:

```bash
php artisan tinker
```

```php
// Verificar estructura de la tabla
Schema::getColumnListing('cortes');

// Verificar datos migrados
App\Models\Corte::first();
```

## Cambios en el Código

### Modelo Corte (`app/Models/Corte.php`)

- Agregados nuevos campos al `$fillable`
- Agregados `$casts` para tipos de datos
- Nuevos métodos para manejar colores JSON
- Métodos para formatear fechas y estados

### Request (`app/Http/Requests/CorteRequest.php`)

- Actualizadas validaciones para nuevos campos
- Agregadas validaciones para colores JSON
- Mejorados mensajes de error

### Controller (`app/Http/Controllers/CorteController.php`)

- Actualizado para manejar nuevos campos
- Mejorado manejo de colores JSON
- Mantenida compatibilidad con datos existentes

### Repository (`app/Repositories/CorteRepository.php`)

- Actualizadas consultas para nuevos campos
- Agregados métodos para tipos de tela
- Mejoradas estadísticas con nuevos campos

## Nuevas Funcionalidades

### Manejo de Colores JSON

```php
// Crear corte con colores JSON
$corte = Corte::create([
    'numero_corte' => 1,
    'tipo_tela' => 'Algodón',
    'cantidad_encimadas' => 5,
    'colores' => [
        'rojo' => 23,
        'amarillo' => 15,
        'azul' => 8
    ],
    'cantidad_total' => 46,
    // ... otros campos
]);

// Obtener colores formateados
echo $corte->colores_formateados; // "Rojo: 23, Amarillo: 15, Azul: 8"

// Obtener cantidad total de colores
echo $corte->cantidad_total_colores; // 46
```

### Estadísticas Mejoradas

```php
$stats = $corteRepository->getStats();
// Ahora incluye:
// - total_encimadas
// - Mejor manejo de cantidades totales
```

## Compatibilidad

La refactorización mantiene compatibilidad con:
- Datos existentes (migrados automáticamente)
- APIs existentes (con campos adicionales)
- Vistas existentes (requieren actualización para nuevos campos)

## Próximos Pasos

1. Actualizar las vistas para mostrar nuevos campos
2. Actualizar formularios para incluir nuevos campos
3. Actualizar reportes para incluir nuevas estadísticas
4. Probar funcionalidad completa del sistema

## Notas Importantes

- Los datos existentes se migran automáticamente
- El campo `colores` ahora es de tipo JSON
- Los nuevos campos son opcionales en la migración inicial
- Se recomienda hacer backup antes de ejecutar la migración
