<?php

// Front Controller Entry Point

// Session start if needed for flash messages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define Base URL dynamically
$scriptName = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$baseUrl = $protocol . "://" . $host . ($scriptName === '/' ? '' : $scriptName);
$baseUrl = rtrim($baseUrl, '/');

define('BASEURL', $baseUrl);

// Core Requirements
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../core/Flasher.php';

// Autoload Models
spl_autoload_register(function ($className) {
    $modelFile = __DIR__ . '/../app/models/' . $className . '.php';
    if (file_exists($modelFile)) {
        require_once $modelFile;
    }
});

// Run Application
$app = new Router();
