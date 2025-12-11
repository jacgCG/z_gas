<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../modelo/unidades.php";
require_once "../modelo/historial.php";

$unidades  = new Unidades();
$historial = new Historial();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $accion = $_POST['accion'] ?? '';
    $IDU    = $_POST['IDU'] ?? null;

    // CREAR UNIDAD
    if ($accion === 'crear') {

        // Pasar IDE seleccionado
        $IDE = $_POST['IDE'] ?? null;

        $newId = $unidades->crear(
            $IDE,
            $_POST['placa'],
            $_POST['descripcion'],
            $_POST['kilometraje'],
            $_POST['estado'],
            $_POST['numero_serie']
        );

        if ($newId) {
            // Obtener la descripción de la unidad recién creada
            $unidad = $unidades->obtenerPorId($newId);
            $descripcionUnidad = $unidad['descripcion'] ?? '';

            // Registrar historial usando la descripción de la unidad
            $historial->crear(
                null,
                $newId,
                null,
                'unidad_crear',
                $descripcionUnidad
            );
        }
    }

    // ACTUALIZAR CAMPOS
    $campos = [
        'actualizar_placa'        => ['placa',        $_POST['placa'] ?? null],
        'actualizar_descripcion'  => ['descripcion',  $_POST['descripcion'] ?? null],  
        'actualizar_kilometraje'  => ['kilometraje',  $_POST['kilometraje'] ?? null],
        'actualizar_estado'       => ['estado',       $_POST['estado'] ?? null],
        'actualizar_numero_serie' => ['numero_serie', $_POST['numero_serie'] ?? null],
        'actualizar_empleado'     => ['IDE',          $_POST['IDE'] ?? null],
    ];

    if (isset($campos[$accion])) {
        $campo = $campos[$accion][0];
        $valor = $campos[$accion][1];

        // Ejecutar actualización dinámica
        $unidades->actualizar(
            $IDU,
            $campo === 'placa'        ? $valor : null,
            $campo === 'descripcion'  ? $valor : null,
            $campo === 'kilometraje'  ? $valor : null,
            $campo === 'estado'       ? $valor : null,
            $campo === 'numero_serie' ? $valor : null,
            $campo === 'IDE'          ? $valor : null
        );

        // Obtener la descripción actualizada
        $unidad = $unidades->obtenerPorId($IDU);
        $descripcionUnidad = $unidad['descripcion'] ?? '';

        // Registrar historial usando la descripción actual
        $historial->crear(
            null,
            $IDU,
            null,
            'unidad_actualizar',
            $descripcionUnidad
        );
    }

    // ELIMINAR UNIDAD
    if ($accion === 'eliminar') {
        $unidades->eliminar($IDU);

        $historial->crear(
            null,
            $IDU,
            null,
            'unidad_eliminar',
            "Unidad eliminada"
        );
    }

    header("Location: ../vista/unidades.php");
    exit;
}
?>
