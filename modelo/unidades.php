<?php
require_once (__DIR__ . '/../controlador/conexion.php');

class Unidades {
    private $conn;       
    private $table = "unidades";

    public function __construct() {
        $this->conn = (new Conexion())->conectar();
    }

    // Listar unidades
    public function listar() {
        $sql = "SELECT IDU, estado, kilometraje, numero_serie, placa, Descripcion AS descripcion, IDE FROM $this->table";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por ID
    public function obtenerPorId($IDU) {
        $sql = "SELECT * FROM $this->table WHERE IDU = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$IDU]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Crear unidad con empleado asignado
    public function crear($IDE, $placa, $descripcion, $kilometraje, $estado, $numero_serie) {
        $sql = "INSERT INTO $this->table (IDE, placa, descripcion, kilometraje, estado, numero_serie)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $ok = $stmt->execute([$IDE, $placa, $descripcion, $kilometraje, $estado, $numero_serie]);

        if ($ok) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    // Actualizar unidad, incluyendo empleado
    public function actualizar($IDU, $placa=null, $descripcion=null, $kilometraje=null, $estado=null, $numero_serie=null, $IDE=null) {
        $sql = "UPDATE $this->table SET
                placa = COALESCE(?, placa),
                descripcion = COALESCE(?, descripcion),
                kilometraje = COALESCE(?, kilometraje),
                estado = COALESCE(?, estado),
                numero_serie = COALESCE(?, numero_serie),
                IDE = COALESCE(?, IDE)
                WHERE IDU = ?";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            $placa,
            $descripcion,
            $kilometraje,
            $estado,
            $numero_serie,
            $IDE,
            $IDU
        ]);
    }

    // Eliminar unidad y su historial
    public function eliminar($IDU) {
        // Primero eliminar historial asociado
        $sql1 = "DELETE FROM historial WHERE IDU = ?";
        $stmt1 = $this->conn->prepare($sql1);
        $stmt1->execute([$IDU]);

        // Después eliminar unidad
        $sql2 = "DELETE FROM $this->table WHERE IDU = ?";
        $stmt2 = $this->conn->prepare($sql2);
        return $stmt2->execute([$IDU]);
    }
}
?>