<?php
require_once __DIR__ . '/conexion.php';

class LoginController {

    public function login($nombreU, $contrasena) {
        $conn = (new Conexion())->conectar();

        // Consulta segura con prepared statement
        $query = $conn->prepare("SELECT IDL, NombreU, contrasena
                                 FROM login
                                 WHERE NombreU = ?");
        $query->execute([$nombreU]);

        // Obtener el usuario
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        
        // Validar datos en texto plano
        if ($usuario && $usuario["contrasena"] === $contrasena) {
            return $usuario;     // ✔ Login correcto
        } else {
            return false;        // ✘ Usuario o contraseña incorrectos
        }
    }

}
