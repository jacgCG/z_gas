<?php
require_once(__DIR__ . '/../controlador/conexion.php');

function agregarUsuario($nombre, $contrasena) {
    
    $conexion = new Conexion();
    $pdo = $conexion->conectar(); 

    try {
        $sql = "INSERT INTO login (NombreU, contrasena) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$nombre, $contrasena]);
    } catch (PDOException $e) {
        echo "Error al agregar usuario: " . $e->getMessage();
        return false;
    }
}
?>
