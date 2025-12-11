<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Si ya hay sesión, redirige al menú
if (isset($_SESSION['user'])) {
    header("Location: vista/menu.php");
    exit();
}

require_once __DIR__ . '/controlador/login.php';

// Procesar login
if (isset($_POST['login'])) {
    $controller = new LoginController();
    $loginOk = $controller->login($_POST['nombreU'], $_POST['contrasena']);
    
    if ($loginOk) {
    unset($loginOk["contrasena"]); // No guarda contraseñas en sesión
    $_SESSION['user'] = $loginOk;
    header("Location: vista/menu.php");
    exit();

    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}

// Cargar vista de login
include __DIR__ . '/vista/login.php';
