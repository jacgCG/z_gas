<?php
require_once(__DIR__ . '/../controlador/conexion.php');

class Empleado {
    private $conn;
    private $table = "empleado";

    public function __construct() {
        $this->conn = (new Conexion())->conectar();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerPorId($IDE) {
        $sql = "SELECT * FROM $this->table WHERE IDE = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$IDE]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function crear($nombre, $apellidos, $correo, $telefono, $tipoE) {
       
        $sql = "INSERT INTO $this->table (nombre, apellidos, correo, telefono, tipoE)
            VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([$nombre, $apellidos, $correo, $telefono, $tipoE]);
        if ($ok) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function actualizar($IDE, $nombre=null, $apellidos=null, $correo=null, $telefono=null, $tipoE=null) {
        $sql = "UPDATE $this->table SET
                    nombre = COALESCE(?, nombre),
                    apellidos = COALESCE(?, apellidos),
                    correo = COALESCE(?, correo),
                    telefono = COALESCE(?, telefono),
                    tipoE = COALESCE(?, tipoE)
                WHERE IDE = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$nombre, $apellidos, $correo, $telefono, $tipoE, $IDE]);
    }

    public function eliminar($IDE) {
        $sql = "DELETE FROM $this->table WHERE IDE = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$IDE]);
    }
}
