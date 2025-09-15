# Guía de Refactorización de Componentes - JR2 System

## 📁 Nueva Estructura de Archivos CSS

```
resources/css/
├── variables.css      # Variables CSS globales
├── app.css           # Archivo principal (importa todos los demás)
├── components.css    # Estilos de componentes generales
├── navbar.css        # Estilos específicos del navbar/sidebar
├── modals.css        # Estilos de modales
├── buttons.css       # Estilos de botones
└── stats-cards.css   # Estilos de tarjetas de estadísticas
```

## 🎯 Componentes Refactorizados

### 1. **Modales** (`modals.css`)
- ✅ `delete-modal-refactored.blade.php`
- ✅ Estilos organizados por funcionalidad
- ✅ Variables CSS centralizadas
- ✅ Animaciones optimizadas

### 2. **Botones** (`buttons.css`)
- ✅ `delete-button-refactored.blade.php`
- ✅ `primary-refactored.blade.php`
- ✅ Sistema de variantes consistente
- ✅ Estados de loading integrados

### 3. **Stats Cards** (`stats-cards.css`)
- ✅ `cortes-stats-refactored.blade.php`
- ✅ Grid system responsive
- ✅ Animaciones de entrada
- ✅ Variantes de color organizadas

## 🔧 Cómo Usar los Componentes Refactorizados

### **1. Modales**

#### **Antes (con estilos inline):**
```php
<div class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-neutral-800 rounded-xl shadow-2xl border border-neutral-200 dark:border-neutral-700 max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0">
        <!-- contenido -->
    </div>
</div>
```

#### **Después (con clases CSS):**
```php
<div class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-icon modal-icon-danger">
                <i class="ri-alert-line text-lg"></i>
            </div>
            <div>
                <h3 class="modal-title">{{ $modalTitle }}</h3>
                <p class="modal-description">{{ $modalDescription }}</p>
            </div>
        </div>
        <!-- resto del contenido -->
    </div>
</div>
```

### **2. Botones**

#### **Antes (lógica PHP compleja):**
```php
@php
    $variants = [
        'danger' => [
            'bg' => 'bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700',
            'text' => 'text-white',
            'focus' => 'focus:ring-red-500'
        ]
    ];
@endphp
```

#### **Después (clases CSS simples):**
```php
<button class="btn btn-md btn-danger">
    <i class="ri-delete-bin-line btn-icon"></i>
    Eliminar
</button>
```

### **3. Stats Cards**

#### **Antes (estilos repetitivos):**
```php
<div class="bg-white dark:bg-neutral-800 rounded-xl shadow-sm border border-neutral-200 dark:border-neutral-700 p-6 hover:shadow-md transition-all duration-200">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/20 rounded-lg flex items-center justify-center">
                <!-- icono -->
            </div>
        </div>
        <!-- contenido -->
    </div>
</div>
```

#### **Después (clases semánticas):**
```php
<div class="stats-card stats-card-primary stats-card-animate">
    <div class="stats-card-content">
        <div class="stats-card-icon">
            <i class="ri-scissors-cut-line text-lg"></i>
        </div>
        <div class="stats-card-info">
            <p class="stats-card-label">Total de Cortes</p>
            <p class="stats-card-value">{{ $totalCortes }}</p>
        </div>
    </div>
</div>
```

## 📋 Clases CSS Disponibles

### **Modales**
```css
.modal-overlay          /* Contenedor del modal */
.modal-content          /* Contenido del modal */
.modal-header           /* Encabezado del modal */
.modal-body             /* Cuerpo del modal */
.modal-footer           /* Pie del modal */
.modal-icon             /* Icono del modal */
.modal-icon-danger      /* Icono de peligro */
.modal-icon-warning     /* Icono de advertencia */
.modal-icon-success     /* Icono de éxito */
.modal-icon-info        /* Icono de información */
.modal-title            /* Título del modal */
.modal-description      /* Descripción del modal */
.modal-message          /* Mensaje del modal */
.modal-button           /* Botón del modal */
.modal-button-cancel    /* Botón de cancelar */
.modal-button-confirm   /* Botón de confirmar */
```

### **Botones**
```css
.btn                    /* Botón base */
.btn-sm                 /* Botón pequeño */
.btn-md                 /* Botón mediano */
.btn-lg                 /* Botón grande */
.btn-xl                 /* Botón extra grande */
.btn-primary            /* Botón primario */
.btn-secondary          /* Botón secundario */
.btn-success            /* Botón de éxito */
.btn-danger             /* Botón de peligro */
.btn-warning            /* Botón de advertencia */
.btn-outline            /* Botón outline */
.btn-outline-danger     /* Botón outline peligro */
.btn-outline-success    /* Botón outline éxito */
.btn-ghost              /* Botón ghost */
.btn-subtle-danger      /* Botón sutil peligro */
.btn-loading            /* Estado de carga */
.btn-full               /* Ancho completo */
.btn-icon-only          /* Solo icono */
```

### **Stats Cards**
```css
.stats-card             /* Tarjeta base */
.stats-card-content     /* Contenido de la tarjeta */
.stats-card-icon        /* Icono de la tarjeta */
.stats-card-info        /* Información de la tarjeta */
.stats-card-label       /* Etiqueta de la tarjeta */
.stats-card-value       /* Valor de la tarjeta */
.stats-card-percentage  /* Porcentaje de la tarjeta */
.stats-card-primary     /* Variante primaria */
.stats-card-success     /* Variante éxito */
.stats-card-warning     /* Variante advertencia */
.stats-card-danger      /* Variante peligro */
.stats-card-info        /* Variante información */
.stats-card-secondary   /* Variante secundaria */
.stats-card-sm          /* Tamaño pequeño */
.stats-card-lg          /* Tamaño grande */
.stats-card-animate     /* Animación de entrada */
.stats-grid             /* Grid de tarjetas */
.stats-grid-1           /* Grid 1 columna */
.stats-grid-2           /* Grid 2 columnas */
.stats-grid-3           /* Grid 3 columnas */
.stats-grid-4           /* Grid 4 columnas */
.stats-grid-5           /* Grid 5 columnas */
.stats-grid-6           /* Grid 6 columnas */
```

## 🚀 Migración de Componentes

### **Paso 1: Backup de archivos actuales**
```bash
# Crear backups
cp resources/views/components/delete-modal.blade.php resources/views/components/delete-modal.blade.php.backup
cp resources/views/components/delete-button.blade.php resources/views/components/delete-button.blade.php.backup
cp resources/views/components/cortes-stats.blade.php resources/views/components/cortes-stats.blade.php.backup
cp resources/views/components/buttons/primary.blade.php resources/views/components/buttons/primary.blade.php.backup
```

### **Paso 2: Aplicar componentes refactorizados**
```bash
# Usar versiones refactorizadas
cp resources/views/components/delete-modal-refactored.blade.php resources/views/components/delete-modal.blade.php
cp resources/views/components/delete-button-refactored.blade.php resources/views/components/delete-button.blade.php
cp resources/views/components/cortes-stats-refactored.blade.php resources/views/components/cortes-stats.blade.php
cp resources/views/components/buttons/primary-refactored.blade.php resources/views/components/buttons/primary.blade.php
```

### **Paso 3: Compilar CSS**
```bash
npm run build
# o
php artisan vite:build
```

## 🎨 Personalización

### **Cambiar colores de modales:**
```css
:root {
    --modal-bg-light: white;
    --modal-bg-dark: rgb(38, 38, 38);
    --modal-border-light: rgb(229, 231, 235);
    --modal-border-dark: rgb(64, 64, 64);
}
```

### **Cambiar colores de botones:**
```css
.btn-primary {
    background: linear-gradient(to right, rgb(236, 72, 153), rgb(219, 39, 119));
}
```

### **Cambiar colores de stats cards:**
```css
.stats-card-primary .stats-card-icon {
    background: rgb(253, 242, 248);
    color: rgb(219, 39, 119);
}
```

## 📊 Beneficios de la Refactorización

### ✅ **Mantenibilidad**
- Estilos organizados por componente
- Variables CSS centralizadas
- Fácil localización de estilos

### ✅ **Performance**
- CSS optimizado y minificado
- Menos conflictos entre estilos
- Carga más eficiente

### ✅ **Escalabilidad**
- Fácil agregar nuevos componentes
- Reutilización de variables
- Estructura modular

### ✅ **Consistencia**
- Nomenclatura uniforme
- Patrones establecidos
- Fácil onboarding

### ✅ **Accesibilidad**
- Estilos optimizados para contraste alto
- Soporte para movimiento reducido
- Mejor experiencia en lectores de pantalla

## 🔍 Debugging y Troubleshooting

### **Problema: Estilos no se aplican**
```bash
# Limpiar caché de Vite
npm run build
# o
php artisan vite:build
```

### **Problema: Conflictos de CSS**
1. Verificar orden de imports en `app.css`
2. Usar DevTools para identificar estilos conflictivos
3. Aumentar especificidad si es necesario

### **Problema: Animaciones no funcionan**
1. Verificar que las clases de animación estén aplicadas
2. Comprobar que no hay `prefers-reduced-motion: reduce`
3. Revisar que los elementos tengan las dimensiones correctas

## 📚 Próximos Pasos

1. **Aplicar la misma estructura a otros componentes**
2. **Crear un sistema de design tokens**
3. **Implementar testing de CSS**
4. **Agregar herramientas de linting CSS**
5. **Crear documentación interactiva**

## 🎯 Checklist de Migración

- [x] Crear archivos CSS dedicados
- [x] Refactorizar componentes principales
- [x] Actualizar imports en `app.css`
- [x] Crear documentación
- [ ] Probar en diferentes dispositivos
- [ ] Verificar accesibilidad
- [ ] Optimizar para producción
- [ ] Crear tests automatizados
