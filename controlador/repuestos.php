<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../modelo/repuestos.php";
require_once "../modelo/historial.php";
require_once "../modelo/unidades.php";

$model = new Repuestos();
$historial = new Historial();
$unidadesModel = new Unidades();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    // Acción para crear un repuesto
    if ($accion === "crear") {
        // Recibimos los datos del formulario
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio_unitario = $_POST['precio_unitario'];
        $stock = $_POST['stock'];
        $IDU = $_POST['IDU'] ?? null; // Unidad seleccionada en el formulario
        $tipoE = $_POST['tipoE'] ?? ''; // Tipo de mantenimiento (Preventivo/Correctivo)

        // Calcular el costo total (precio unitario * cantidad)
        $costo_total = $precio_unitario * $stock;

        // Crear repuesto
        $newID = $model->crear($nombre, $descripcion, $precio_unitario, $stock);

        // Registrar automáticamente en historial si se seleccionó unidad
        if ($IDU) {
            // Traer IDE desde la unidad
            $unidad = $unidadesModel->obtenerPorId($IDU);
            $IDE = $unidad['IDE'] ?? null;

            // Registrar en el historial con tipo de mantenimiento
            $historial->crear(
                $IDE,             // IDE de la unidad
                $IDU,             // Unidad
                $costo_total,     // Costo total (precio unitario * cantidad)
                $tipoE,           // Tipo de mantenimiento (Preventivo/Correctivo)
                $nombre           // Descripción
            );
        }

    } 
    // Acción para eliminar un repuesto
    elseif ($accion === "eliminar") {
        $IDR = $_POST['IDR'];
        $model->eliminar($IDR);
    } 
    // Acción para actualizar un campo
    else {
        $map = [
            "actualizar_nombre" => "nombre",
            "actualizar_descripcion" => "descripcion",
            "actualizar_precio" => "precio_unitario",
            "actualizar_stock" => "stock"
        ];

        if (isset($map[$accion])) {
            $campo = $map[$accion];
            $valor = $_POST[$campo] ?? null;
            $IDR = $_POST['IDR'] ?? null;

            // Si se actualiza el precio o el stock, recalculamos el costo total
            if ($campo === "precio_unitario" || $campo === "stock") {
                // Obtener los valores actuales de precio unitario y stock
                $repuesto = $model->obtenerPorId($IDR);
                $precio_unitario = $repuesto['precio_unitario'];
                $stock = $repuesto['stock'];

                if ($campo === "precio_unitario") {
                    $precio_unitario = $valor; // Actualizamos el precio unitario
                } elseif ($campo === "stock") {
                    $stock = $valor; // Actualizamos el stock
                }

                // Calcular el nuevo costo total
                $costo_total = $precio_unitario * $stock;

                // Actualizar el campo y el costo total
                $model->actualizarCampo($IDR, 'precio_unitario', $precio_unitario);
                $model->actualizarCampo($IDR, 'stock', $stock);
                $model->actualizarCampo($IDR, 'costo', $costo_total); // Asegúrate de tener la columna 'costo' en la base de datos
            } else {
                // Para otros campos como nombre o descripción
                $model->actualizarCampo($IDR, $campo, $valor);
            }
        }
    }

    // Redirigir a la página de repuestos
    header("Location: ../vista/repuestos.php");
    exit;
}
?>
