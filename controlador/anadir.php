<?php
session_start(); 

require_once '../modelo/anadir.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['NombreU'];
    $contrasena = $_POST['contrasena'];

    if (agregarUsuario($nombre, $contrasena)) {
        header("Location: ../vista/usuarios.php");
        exit();
    } else {
        echo "Error al añadir el usuario.";
    }
}
?>