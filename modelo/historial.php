<?php
require_once __DIR__ . '/../controlador/conexion.php';

class Historial {
    private $pdo;

    public function __construct() {
        $this->pdo = (new Conexion())->conectar();
    }

    // Listar historial incluyendo descripción de la unidad
    public function listarConDescripcionUnidad() {
        $sql = "SELECT h.IDh, h.IDE, h.IDU, h.costo, h.tipoE, 
                       u.descripcion AS descripcion_unidad, h.fecha
                FROM historial h
                LEFT JOIN unidades u ON h.IDU = u.IDU
                ORDER BY h.fecha DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear historial
    public function crear($IDE = null, $IDU = null, $costo = null, $tipoE = null, $descripcion = null) {
        $fields = [];
        $placeholders = [];
        $values = [];

        if ($IDE !== null) {
            $fields[] = 'IDE';
            $placeholders[] = '?';
            $values[] = $IDE;
        }
        if ($IDU !== null) {
            $fields[] = 'IDU';
            $placeholders[] = '?';
            $values[] = $IDU;
        }
        if ($costo !== null) {
            $fields[] = 'costo';
            $placeholders[] = '?';
            $values[] = $costo;
        }
        if ($tipoE !== null) {
            $fields[] = 'tipoE';
            $placeholders[] = '?';
            $values[] = $tipoE;
        }
        if ($descripcion !== null) {
            $fields[] = 'descripcion';
            $placeholders[] = '?';
            $values[] = $descripcion;
        }

        $fields[] = 'fecha';
        $placeholders[] = 'NOW()';

        $sql = 'INSERT INTO historial (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $placeholders) . ')';
        $stmt = $this->pdo->prepare($sql);
        try {
            $ok = $stmt->execute($values);
            if ($ok) {
                return $this->pdo->lastInsertId();
            }
            return false;
        } catch (PDOException $e) {
            error_log('Historial::crear error: ' . $e->getMessage());
            return false;
        }
    }
}
?>
