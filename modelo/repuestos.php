<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../controlador/conexion.php'; // O tu forma de conectar PDO

class Repuestos {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->conectar();
    }

    // Listar todos los repuestos
    public function listar() {
        $stmt = $this->pdo->query("SELECT * FROM repuestos ORDER BY IDR ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear nuevo repuesto
    public function crear($nombre, $descripcion, $precio_unitario, $stock, $IDU = null) {
    $sql = "INSERT INTO repuestos (nombre, descripcion, precio_unitario, stock, IDU) VALUES (?, ?, ?, ?, ?)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $precio_unitario, $stock, $IDU]);

    return $this->pdo->lastInsertId();
}

    // Actualizar un campo específico de un repuesto
    public function actualizarCampo($IDR, $campo, $valor) {
        $campos_permitidos = ['nombre', 'descripcion', 'precio_unitario', 'stock'];
        if (!in_array($campo, $campos_permitidos)) return false;

        $sql = "UPDATE repuestos SET $campo = ? WHERE IDR = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$valor, $IDR]);
    }

    // Obtener repuesto por ID
    public function obtenerPorId($IDR) {
        $sql = "SELECT * FROM repuestos WHERE IDR = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$IDR]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Eliminar un repuesto
    public function eliminar($IDR) {
        $sql = "DELETE FROM repuestos WHERE IDR = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$IDR]);
    }

    // Opcional: buscar repuestos por nombre
    public function buscar($nombre) {
        $sql = "SELECT * FROM repuestos WHERE nombre LIKE ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["%$nombre%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
