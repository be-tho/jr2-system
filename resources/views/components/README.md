# Componentes de Eliminación

Este directorio contiene componentes reutilizables para manejar la eliminación de elementos con confirmación.

## 🗑️ DeleteButton

Componente simple con confirmación `confirm()` integrada.

### Uso Básico

```blade
<x-delete-button 
    :route="route('items.delete', $item)"
    title="Eliminar"
    message="¿Estás seguro que deseas eliminar este elemento?"
/>
```

### Parámetros

| Parámetro | Tipo | Defecto | Descripción |
|-----------|------|---------|-------------|
| `route` | string | **requerido** | Ruta de eliminación |
| `title` | string | `'Eliminar'` | Texto del botón |
| `message` | string | `'¿Estás seguro...'` | Mensaje de confirmación |
| `size` | string | `'md'` | Tamaño: `sm`, `md`, `lg` |
| `variant` | string | `'danger'` | Estilo: `danger`, `outline-danger`, `subtle-danger` |
| `icon` | string | `'ri-delete-bin-line'` | Icono Remix Icon |
| `fullWidth` | boolean | `false` | Botón ancho completo |
| `class` | string | `''` | Clases adicionales del form |
| `buttonClass` | string | `''` | Clases adicionales del botón |

### Ejemplos

```blade
{{-- Botón pequeño sutil para tablas --}}
<x-delete-button 
    :route="route('categories.destroy', $category)"
    title=""
    size="sm"
    variant="subtle-danger"
    buttonClass="!p-2"
/>

{{-- Botón ancho completo --}}
<x-delete-button 
    :route="route('items.delete', $item)"
    title="Eliminar Elemento"
    fullWidth="true"
/>
```

## 🔄 DeleteModal

Componente avanzado con modal de confirmación personalizado.

### Uso Básico

```blade
<x-delete-modal 
    :route="route('items.delete', $item)"
    triggerText="Eliminar"
    modalTitle="Confirmar eliminación"
    modalMessage="¿Estás seguro de que quieres eliminar este elemento?"
/>
```

### Parámetros

| Parámetro | Tipo | Defecto | Descripción |
|-----------|------|---------|-------------|
| `route` | string | **requerido** | Ruta de eliminación |
| `triggerText` | string | `'Eliminar'` | Texto del botón trigger |
| `modalTitle` | string | `'Confirmar eliminación'` | Título del modal |
| `modalMessage` | string | `'¿Estás seguro...'` | Mensaje principal |
| `modalDescription` | string | `'Esta acción no se puede deshacer.'` | Descripción adicional |
| `confirmText` | string | `'Sí, eliminar'` | Texto botón confirmar |
| `cancelText` | string | `'Cancelar'` | Texto botón cancelar |
| `size` | string | `'md'` | Tamaño del trigger |
| `variant` | string | `'danger'` | Estilo del trigger |
| `icon` | string | `'ri-delete-bin-line'` | Icono |
| `fullWidth` | boolean | `false` | Trigger ancho completo |
| `triggerClass` | string | `''` | Clases adicionales del trigger |
| `itemName` | string | `'elemento'` | Nombre del elemento (para contexto) |

### Ejemplo Avanzado

```blade
<x-delete-modal 
    :route="route('products.delete', $product)"
    triggerText="Eliminar Producto"
    modalTitle="Eliminar Producto"
    modalMessage="¿Estás seguro de que quieres eliminar este producto?"
    modalDescription="Se eliminarán todas las imágenes y datos asociados. Esta acción no se puede deshacer."
    confirmText="Sí, eliminar producto"
    cancelText="Conservar producto"
    fullWidth="true"
    itemName="producto"
/>
```

## 🎨 Variantes de Estilo

### Danger (Defecto)
- Fondo rojo degradado
- Texto blanco
- Para acciones destructivas principales

### Outline Danger
- Borde rojo
- Texto rojo
- Fondo transparente
- Para contextos sutiles

### Subtle Danger
- Fondo rojo claro
- Texto rojo
- Para integración en interfaces claras

## 🔧 Características Técnicas

- ✅ **Prevención de loading infinito**: Maneja correctamente la cancelación
- ✅ **Accesibilidad**: Soporte para teclado (ESC cierra modales)
- ✅ **Responsive**: Se adapta a dispositivos móviles
- ✅ **Dark mode**: Soporte completo para tema oscuro
- ✅ **Animations**: Transiciones suaves
- ✅ **Prevention doble envío**: Deshabilita botones tras confirmar

## 🚀 Migración desde formularios manuales

### Antes
```blade
<form action="{{ route('items.delete', $item) }}" method="POST" 
      onsubmit="return confirm('¿Seguro?')">
    @csrf
    @method('DELETE')
    <button type="submit">Eliminar</button>
</form>
```

### Después
```blade
<x-delete-button 
    :route="route('items.delete', $item)"
    message="¿Seguro?"
/>
```

## 📱 Cuándo usar cada componente

### Usa `delete-button` cuando:
- Necesites confirmación simple
- Tengas espacio limitado (tablas, listas)
- Quieras consistencia rápida

### Usa `delete-modal` cuando:
- Necesites explicar consecuencias
- La acción sea muy destructiva
- Quieras mejor UX en pantallas principales
