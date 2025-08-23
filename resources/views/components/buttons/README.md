# Componentes de Botones - JR2 System

Este directorio contiene componentes de botones reutilizables que siguen el diseño consistente de la aplicación.

## Componentes Disponibles

### 1. Botón Primario (`primary.blade.php`)
Botón principal con color fucsia, usado para acciones principales.

```blade
<x-buttons.primary>Guardar</x-buttons.primary>
<x-buttons.primary size="lg">Guardar Cambios</x-buttons.primary>
<x-buttons.primary href="/ruta">Ir a Ruta</x-buttons.primary>
```

### 2. Botón Secundario (`secondary.blade.php`)
Botón secundario con estilo neutral, usado para acciones secundarias.

```blade
<x-buttons.secondary>Cancelar</x-buttons.secondary>
<x-buttons.secondary size="sm">Volver</x-buttons.secondary>
```

### 3. Botón Outline (`outline.blade.php`)
Botón con borde fucsia y texto fucsia, usado para acciones alternativas.

```blade
<x-buttons.outline>Editar</x-buttons.outline>
<x-buttons.outline size="xl">Configurar</x-buttons.outline>
```

### 4. Botón de Peligro (`danger.blade.php`)
Botón rojo para acciones destructivas como eliminar.

```blade
<x-buttons.danger>Eliminar</x-buttons.danger>
<x-buttons.danger size="lg">Confirmar Eliminación</x-buttons.danger>
```

### 5. Botón de Éxito (`success.blade.php`)
Botón verde para acciones positivas como confirmar.

```blade
<x-buttons.success>Confirmar</x-buttons.success>
<x-buttons.success size="sm">Aceptar</x-buttons.success>
```

## Tamaños Disponibles

- `sm`: Pequeño (px-3 py-1.5 text-sm)
- `md`: Mediano (px-4 py-2 text-sm) - **Por defecto**
- `lg`: Grande (px-6 py-3 text-base)
- `xl`: Extra grande (px-8 py-4 text-lg)

## Propiedades

### Para Botones
- `type`: Tipo de botón (button, submit, reset)
- `size`: Tamaño del botón
- Cualquier atributo HTML válido

### Para Enlaces
- `href`: URL del enlace
- `size`: Tamaño del botón
- Cualquier atributo HTML válido

## Ejemplos de Uso

### Formulario
```blade
<form>
    <!-- Campos del formulario -->
    
    <div class="flex gap-3">
        <x-buttons.primary type="submit">Guardar</x-buttons.primary>
        <x-buttons.secondary type="button">Cancelar</x-buttons.secondary>
    </div>
</form>
```

### Acciones de Tabla
```blade
<div class="flex gap-2">
    <x-buttons.outline size="sm" href="{{ route('articulos.edit', $articulo) }}">
        <i class="ri-edit-line"></i> Editar
    </x-buttons.outline>
    
    <x-buttons.danger size="sm" type="button" onclick="eliminarArticulo({{ $articulo->id }})">
        <i class="ri-delete-bin-line"></i> Eliminar
    </x-buttons.danger>
</div>
```

### Navegación
```blade
<div class="flex gap-4">
    <x-buttons.primary href="{{ route('cortes.create') }}">
        <i class="ri-add-line"></i> Nuevo Corte
    </x-buttons.primary>
    
    <x-buttons.secondary href="{{ route('cortes.index') }}">
        <i class="ri-list-check"></i> Ver Todos
    </x-buttons.secondary>
</div>
```

## Características del Diseño

- **Colores**: Siguen la paleta fucsia de la aplicación
- **Transiciones**: Animaciones suaves en hover y focus
- **Focus**: Anillo de focus visible para accesibilidad
- **Responsivo**: Se adaptan a diferentes tamaños de pantalla
- **Modo Oscuro**: Soporte completo para tema oscuro
- **Consistencia**: Mismo estilo en toda la aplicación

## Personalización

Los botones pueden ser personalizados pasando clases CSS adicionales:

```blade
<x-buttons.primary class="w-full mt-4">
    Botón Personalizado
</x-buttons.primary>
```

Las clases personalizadas se fusionarán con las clases base del componente.
