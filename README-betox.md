# JR2 System - Sistema de Gestión Textil

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-red.svg" alt="Laravel Version">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP Version">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-brightgreen.svg" alt="Status">
</p>

## 📋 Descripción

**JR2 System** es una aplicación web desarrollada en Laravel para la gestión integral de empresas textiles y de confección. El sistema permite administrar artículos, cortes de tela, temporadas, categorías, costureros y generar reportes detallados para optimizar la producción y el control de inventario.

## ✨ Características Principales

### 🎯 Gestión de Inventario
- **Artículos**: Administración completa de productos con códigos, precios, stock e imágenes
- **Categorías**: Organización por categorías de productos
- **Temporadas**: Control por temporadas de producción
- **Cortes**: Gestión de cortes de tela con colores, cantidades y estados

### 👥 Gestión de Personal
- **Costureros**: Registro y seguimiento de trabajadores
- **Usuarios**: Sistema de autenticación con roles y permisos
- **Roles**: Administrador y usuarios con diferentes niveles de acceso

### 📊 Reportes y Estadísticas
- Dashboard con estadísticas en tiempo real
- Reportes de artículos y cortes exportables a PDF
- Estadísticas de producción y rendimiento
- Integración con tasas de cambio de dólar

### 🔧 Funcionalidades Técnicas
- **Optimización de consultas**: Sistema de consultas optimizadas para mejor rendimiento
- **Gestión de imágenes**: Procesamiento y optimización de imágenes
- **Cache inteligente**: Sistema de caché para mejorar la velocidad
- **Responsive Design**: Interfaz adaptable a dispositivos móviles

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 11.x** - Framework PHP
- **PHP 8.2+** - Lenguaje de programación
- **MySQL** - Base de datos
- **Spatie Laravel Permission** - Gestión de roles y permisos

### Frontend
- **Tailwind CSS** - Framework de estilos
- **Vite** - Build tool y bundler
- **JavaScript ES6+** - Interactividad del frontend
- **Blade Templates** - Motor de plantillas de Laravel

### Herramientas de Desarrollo
- **Laravel Debugbar** - Debugging en desarrollo
- **Laravel Pint** - Code style fixer
- **PHPUnit** - Testing framework
- **Intervention Image** - Procesamiento de imágenes

## 📦 Instalación

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- Node.js y NPM
- MySQL 5.7+ o MariaDB 10.3+
- Servidor web (Apache/Nginx)

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/tu-usuario/jr2-system.git
   cd jr2-system
   ```

2. **Instalar dependencias de PHP**
   ```bash
   composer install
   ```

3. **Instalar dependencias de Node.js**
   ```bash
   npm install
   ```

4. **Configurar el entorno**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configurar la base de datos**
   Editar el archivo `.env` con los datos de tu base de datos:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=jr2_system
   DB_USERNAME=tu_usuario
   DB_PASSWORD=tu_password
   ```

6. **Ejecutar migraciones y seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Compilar assets**
   ```bash
   npm run build
   ```

8. **Configurar permisos de almacenamiento**
   ```bash
   php artisan storage:link
   ```

## 🚀 Uso

### Acceso al Sistema
- **URL**: `http://tu-dominio.com`
- **Usuario por defecto**: `admin@example.com`
- **Contraseña**: `password`

### Roles de Usuario
- **Administrador**: Acceso completo a todas las funcionalidades
- **Usuario**: Acceso de solo lectura a la mayoría de módulos

### Módulos Principales
1. **Dashboard** - Estadísticas generales del sistema
2. **Artículos** - Gestión de productos
3. **Cortes** - Control de cortes de tela
4. **Categorías** - Organización de productos
5. **Temporadas** - Gestión por temporadas
6. **Costureros** - Registro de personal
7. **Reportes** - Generación de reportes
8. **Usuarios** - Administración de usuarios (solo admin)

## 📁 Estructura del Proyecto

```
jr2-system/
├── app/
│   ├── Console/Commands/     # Comandos de Artisan
│   ├── Http/Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   ├── Repositories/        # Repositorios
│   ├── Services/            # Servicios de negocio
│   └── Traits/              # Traits reutilizables
├── database/
│   ├── migrations/          # Migraciones de BD
│   └── seeders/             # Seeders de datos
├── resources/
│   ├── views/               # Vistas Blade
│   ├── css/                 # Estilos CSS
│   └── js/                  # JavaScript
├── routes/                  # Definición de rutas
└── public/                  # Archivos públicos
```

## 🔧 Comandos Útiles

### Desarrollo
```bash
# Servidor de desarrollo
php artisan serve

# Compilar assets en modo desarrollo
npm run dev

# Observar cambios en assets
npm run watch
```

### Producción
```bash
# Compilar assets para producción
npm run build:prod

# Optimizar autoloader
composer install --optimize-autoloader --no-dev

# Cache de configuración
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Base de Datos
```bash
# Ejecutar migraciones
php artisan migrate

# Rollback de migraciones
php artisan migrate:rollback

# Ejecutar seeders
php artisan db:seed
```

## 🧪 Testing

```bash
# Ejecutar tests
php artisan test

# Tests con coverage
php artisan test --coverage
```

## 📈 Optimizaciones Implementadas

- **Índices de base de datos** optimizados para consultas frecuentes
- **Eager loading** para evitar el problema N+1
- **Cache de consultas** para estadísticas
- **Compresión de imágenes** automática
- **Lazy loading** en componentes pesados
- **Paginación optimizada** para listas grandes

## 🔒 Seguridad

- Autenticación robusta con Laravel
- Sistema de roles y permisos con Spatie
- Validación de datos en requests
- Protección CSRF en formularios
- Sanitización de inputs
- Headers de seguridad configurados

## 📱 Responsive Design

El sistema está completamente optimizado para dispositivos móviles:
- Diseño adaptativo con Tailwind CSS
- Navegación móvil optimizada
- Formularios touch-friendly
- Imágenes responsivas

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo [LICENSE](LICENSE) para más detalles.

## 📞 Soporte

Para soporte técnico o consultas:
- **Email**: soporte@jr2system.com
- **Documentación**: [Wiki del proyecto](https://github.com/tu-usuario/jr2-system/wiki)
- **Issues**: [GitHub Issues](https://github.com/tu-usuario/jr2-system/issues)

## 🎯 Roadmap

### Próximas Características
- [ ] API REST para integración con sistemas externos
- [ ] Notificaciones push para móviles
- [ ] Integración con sistemas de pago
- [ ] Dashboard avanzado con gráficos interactivos
- [ ] Sistema de backup automático
- [ ] Multi-tenancy para múltiples empresas

---

<p align="center">
  Desarrollado con ❤️ usando Laravel
</p>