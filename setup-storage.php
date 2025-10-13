<?php
/**
 * Script para configurar directorios de storage desde el navegador
 * Acceder a: https://tudominio.com/setup-storage.php
 * IMPORTANTE: Eliminar este archivo después de usarlo por seguridad
 */

// Verificar que estamos en el directorio raíz del proyecto
if (!file_exists('artisan')) {
    die('Error: Este archivo debe estar en el directorio raíz del proyecto Laravel');
}

echo "<h1>Configuración de Storage para Laravel</h1>";
echo "<p>Ejecutando en: " . __DIR__ . "</p>";

$basePath = __DIR__;
$storagePath = $basePath . '/storage';
$frameworkPath = $storagePath . '/framework';
$sessionsPath = $frameworkPath . '/sessions';
$cachePath = $frameworkPath . '/cache';
$viewsPath = $frameworkPath . '/views';
$logsPath = $storagePath . '/logs';

$directories = [
    $storagePath,
    $frameworkPath,
    $sessionsPath,
    $cachePath,
    $viewsPath,
    $logsPath,
    $storagePath . '/app',
    $storagePath . '/app/public',
];

echo "<h2>Creando directorios necesarios...</h2>";

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0755, true)) {
            echo "<p style='color: green;'>✓ Directorio creado: $dir</p>";
        } else {
            echo "<p style='color: red;'>✗ Error creando directorio: $dir</p>";
        }
    } else {
        echo "<p style='color: blue;'>✓ Directorio ya existe: $dir</p>";
    }
}

echo "<h2>Verificando permisos de escritura...</h2>";

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "<p style='color: green;'>✓ Permisos correctos: $dir</p>";
        } else {
            echo "<p style='color: red;'>✗ Sin permisos de escritura: $dir</p>";
        }
    }
}

echo "<h2>Creando archivos .gitignore...</h2>";

$gitignoreFiles = [
    $sessionsPath . '/.gitignore',
    $cachePath . '/.gitignore',
    $viewsPath . '/.gitignore',
];

foreach ($gitignoreFiles as $file) {
    if (!file_exists($file)) {
        file_put_contents($file, "*\n!.gitignore\n");
        echo "<p style='color: green;'>✓ Archivo .gitignore creado: $file</p>";
    } else {
        echo "<p style='color: blue;'>✓ Archivo .gitignore ya existe: $file</p>";
    }
}

echo "<h2>Probando escritura de sesión...</h2>";

// Probar crear un archivo de sesión de prueba
$testFile = $sessionsPath . '/test-session-' . time();
if (file_put_contents($testFile, 'test') !== false) {
    echo "<p style='color: green;'>✓ Prueba de escritura exitosa en directorio de sesiones</p>";
    unlink($testFile); // Eliminar archivo de prueba
} else {
    echo "<p style='color: red;'>✗ Error: No se puede escribir en el directorio de sesiones</p>";
}

echo "<h2>Configuración completada</h2>";
echo "<p><strong>IMPORTANTE:</strong> Elimina este archivo (setup-storage.php) por seguridad después de usarlo.</p>";
echo "<p>Ahora puedes acceder a tu aplicación Laravel normalmente.</p>";

// Mostrar información del sistema
echo "<h2>Información del sistema:</h2>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Directorio actual: " . getcwd() . "</p>";
echo "<p>Usuario del servidor web: " . (function_exists('posix_getpwuid') ? posix_getpwuid(posix_geteuid())['name'] : 'No disponible') . "</p>";
?>
