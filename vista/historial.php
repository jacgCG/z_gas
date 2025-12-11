<?php
// Asegúrate de que $registros venga del controlador
if (!isset($registros)) {
    // Si se accede directo, redirigir al controlador
    header("Location: ../controlador/historial.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial - Zeta Gas</title>
    <link rel="stylesheet" href="../estilos/historial.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="contenido">

    <div class="only-print">
        <img src="../img/zgasLog.png" alt="Zeta Gas" class="print-logo">
        <h2>Reporte General de Movimientos</h2>
        <p>Fecha de impresión: <?= date('d/m/Y H:i') ?></p>
        <p>Generado por sistema interno</p>
    </div>

    <div class="botones-superior no-print">
        <h2><i class="fas fa-history"></i> Historial de Movimientos</h2>
        <div>
            <a href="../vista/menu.php" class="btn-nav">
                <i class="fas fa-arrow-left"></i> Volver al menú
            </a>
            
            <button onclick="window.print()" class="btn-nav btn-imprimir">
                <i class="fas fa-print"></i> Imprimir Reporte
            </button>
        </div>
    </div>

    <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th>IDH</th>
                    <th>Empleado</th>
                    <th>Unidad</th>
                    <th>Costo (S/.)</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($registros)): ?>
                    <tr><td colspan="7" style="text-align:center; padding:20px;">No hay registros encontrados.</td></tr>
                <?php else: ?>
                    <?php foreach($registros as $registro): ?>
                    <tr>
                        <td>#<?= htmlspecialchars($registro['IDh']) ?></td>
                        <td>ID: <?= htmlspecialchars($registro['IDE']) ?></td>
                        <td><?= $registro['IDU'] ? 'Unidad #' . htmlspecialchars($registro['IDU']) : '-' ?></td>
                        <td><?= $registro['costo'] ? 'S/. ' . number_format($registro['costo'], 2) : '-' ?></td>
                        
                        <td>
                            <?php 
                                $tipo = strtolower($registro['tipoE'] ?? '');
                                $clase = 'bg-otro';
                                if(strpos($tipo, 'preventivo') !== false) $clase = 'bg-prev';
                                if(strpos($tipo, 'correctivo') !== false) $clase = 'bg-corr';
                            ?>
                            <span class="badge <?= $clase ?>">
                                <?= htmlspecialchars($registro['tipoE'] ?? 'Registro') ?>
                            </span>
                        </td>

                        <td><?= htmlspecialchars($registro['descripcion_unidad'] ?? $registro['descripcion_historial'] ?? $registro['descripcion'] ?? 'Sin descripción') ?></td>
                        <td><?= htmlspecialchars($registro['fecha']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>