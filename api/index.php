<?php
/**
 * Vercel Serverless Entrypoint Router for PHP
 */

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestUri = trim($requestUri, '/');

// Mapping routes
if (empty($requestUri) || $requestUri === 'index.php') {
    require __DIR__ . '/../index.php';
    exit;
}

// Cek file langsung di root (misal auth.php, pinjaman.php, dll)
$fileDirect = __DIR__ . '/../' . $requestUri;
if (file_exists($fileDirect) && is_file($fileDirect) && pathinfo($fileDirect, PATHINFO_EXTENSION) === 'php') {
    require $fileDirect;
    exit;
}

// Cek jika rute tanpa ekstensi .php (misal /auth -> auth.php)
$fileWithPhp = __DIR__ . '/../' . $requestUri . '.php';
if (file_exists($fileWithPhp) && is_file($fileWithPhp)) {
    require $fileWithPhp;
    exit;
}

// Default fallback ke index.php
require __DIR__ . '/../index.php';
