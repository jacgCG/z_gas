<?php
require_once "../modelo/repuestos.php";
require_once "../modelo/unidades.php";

$repuestos_model = new Repuestos();
$repuestos = $repuestos_model->listar();

$unidades_model = new Unidades();
$unidades = $unidades_model->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Repuestos - Zeta Gas</title>
    <link rel="stylesheet" href="../estilos/repuestos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="contenido">

    <div class="botones-superior">
        <h2><i class="fas fa-tools"></i> Registro y Compra de Repuestos</h2>
        <div>
            <a href="menu.php" class="btn-nav"><i class="fas fa-arrow-left"></i> Menú</a>
            <a href="unidades.php" class="btn-nav">Unidades <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="seccion-agregar">
        <h3><i class="fas fa-cart-plus"></i> Registrar nuevo repuesto o compra</h3>

        <form action="../controlador/repuestos.php" method="POST" class="form-repuestos">
            <input type="hidden" name="accion" value="crear">

            <div class="form-group">
                <label>Nombre del repuesto:</label>
                <input type="text" name="nombre" placeholder="Ej: Filtro de aceite" required>
            </div>

            <div class="form-group">
                <label>Precio Unitario (S/.):</label>
                <input type="number" step="0.1" name="precio_unitario" placeholder="0.00" required>
            </div>

            <div class="form-group">
                <label>Cantidad:</label>
                <input type="number" name="stock" placeholder="0" required>
            </div>

            <div class="form-group">
                <label>Asignar a Unidad (Opcional):</label>
                <select name="IDU">
                    <option value="">-- Seleccionar Unidad --</option>
                    <?php foreach ($unidades as $u): ?>
                        <option value="<?= $u['IDU'] ?>">
                            <?= htmlspecialchars($u['placa'] . ' - ' . substr($u['descripcion'], 0, 30)) ?>...
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Tipo Mantenimiento:</label>
                <select name="tipoE">
                    <option value="">-- Seleccionar --</option>
                    <option value="Preventivo">Preventivo</option>
                    <option value="Correctivo">Correctivo</option>
                </select>
            </div>

            <div class="form-group full-width">
                <label>Detalle / Descripción:</label>
                <textarea name="descripcion" placeholder="Detalles adicionales del repuesto o la compra..."></textarea>
            </div>

            <div class="form-group full-width">
                <button type="submit"><i class="fas fa-save"></i> Registrar Repuesto</button>
            </div>
        </form>
    </div>

    <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th style="width: 20%;">Nombre</th>
                    <th style="width: 30%;">Descripción</th>
                    <th style="width: 15%;">Precio Unit.</th>
                    <th style="width: 10%;">Cant.</th>
                    <th style="width: 10%; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($repuestos as $r): ?>
                <tr>
                    <td>#<?= $r['IDR'] ?></td>

                    <td>
                        <form action="../controlador/repuestos.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_nombre">
                            <input type="hidden" name="IDR" value="<?= $r['IDR'] ?>">
                            <input type="text" name="nombre" value="<?= htmlspecialchars($r['nombre']) ?>" required>
                            <button type="submit" title="Guardar"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/repuestos.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_descripcion">
                            <input type="hidden" name="IDR" value="<?= $r['IDR'] ?>">
                            <input type="text" name="descripcion" value="<?= htmlspecialchars($r['descripcion']) ?>">
                            <button type="submit" title="Guardar"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/repuestos.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_precio">
                            <input type="hidden" name="IDR" value="<?= $r['IDR'] ?>">
                            <input type="number" step="0.01" name="precio_unitario" value="<?= $r['precio_unitario'] ?>" required>
                            <button type="submit" title="Guardar"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/repuestos.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_stock">
                            <input type="hidden" name="IDR" value="<?= $r['IDR'] ?>">
                            <input type="number" name="stock" value="<?= $r['stock'] ?>" required style="text-align: center;">
                            <button type="submit" title="Guardar"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td style="text-align: center;">
                        <form action="../controlador/repuestos.php" method="POST" style="justify-content: center;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="IDR" value="<?= $r['IDR'] ?>">
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este repuesto del inventario?')" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>