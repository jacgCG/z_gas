<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../modelo/empleado.php";
require_once "../modelo/historial.php";

$empleado  = new Empleado();
$historial = new Historial();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $accion = $_POST['accion'] ?? '';
    $IDE    = $_POST['IDE'] ?? null;

    
    if ($accion === 'crear') {

        $nombre    = trim($_POST['nombre'] ?? '');
        $apellidos = trim($_POST['apellidos'] ?? '');
        $correo    = trim($_POST['correo'] ?? '');
        $telefono  = trim($_POST['telefono'] ?? '');
        $tipoE     = trim($_POST['tipoE'] ?? '');

        if ($telefono === null || $telefono === '') {
            $telefono = '';
        }

        $newId = $empleado->crear(
            $nombre,
            $apellidos,
            $correo,
            $telefono,
            $tipoE
        );

        if ($newId) {
            $historial->crear(
                $newId,
                null,
                null,
                'empleado_crear',
                "Empleado creado: $nombre $apellidos"
            );
        }
    }

    $campos = [
        'actualizar_nombre'    => ['nombre',    $_POST['nombre']    ?? null],
        'actualizar_apellidos' => ['apellidos', $_POST['apellidos'] ?? null],
        'actualizar_correo'    => ['correo',    $_POST['correo']    ?? null],
        'actualizar_telefono'  => ['telefono',  $_POST['telefono']  ?? null],
        'actualizar_tipoE'     => ['tipoE',     $_POST['tipoE']     ?? null],
    ];

    if (isset($campos[$accion])) {

        $campo = $campos[$accion][0];
        $valor = $campos[$accion][1];

        // Ejecutar actualización dinámica
        $empleado->actualizar(
            $IDE,
            $campo === 'nombre'    ? $valor : null,
            $campo === 'apellidos' ? $valor : null,
            $campo === 'correo'    ? $valor : null,
            $campo === 'telefono'  ? $valor : null,
            $campo === 'tipoE'     ? $valor : null
        );

        // Registrar historial
        $historial->crear(
            $IDE,
            null,
            null,
            'empleado_actualizar',
            "Actualizado campo: $campo"
        );
    }

   
    if ($accion === 'eliminar') {

        $empleado->eliminar($IDE);

        $historial->crear(
            $IDE,
            null,
            null,
            'empleado_eliminar',
            "Empleado eliminado"
        );
    }

    /* Redirección final */
    header("Location: ../vista/empleado.php");
    exit;
}

?>
