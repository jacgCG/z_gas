<?php
require_once "../modelo/unidades.php";
require_once "../modelo/empleado.php";

$unidades_model = new Unidades();
$empleado_model = new Empleado(); 
$unidades = $unidades_model->listar();
$empleados = $empleado_model->listar(); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Unidades - Zeta Gas</title>
    <link rel="stylesheet" href="../estilos/unidades.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="contenido">

    <div class="botones-superior">
        <h2><i class="fas fa-truck-moving"></i> Gestión de Unidades</h2>
        <div>
            <a href="menu.php" class="btn-nav"><i class="fas fa-arrow-left"></i> Menú</a>
            <a href="repuestos.php" class="btn-nav">Repuestos <i class="fas fa-arrow-right"></i></a>
            <a href="empleado.php" class="btn-nav">Empleados <i class="fas fa-user-friends"></i></a>
        </div>
    </div>

    <div class="seccion-agregar">
        <h3><i class="fas fa-plus-circle"></i> Agregar nueva unidad</h3>
        
        <form class="form-registro" action="../controlador/unidades.php" method="POST">
            <input type="hidden" name="accion" value="crear">

            <div>
                <select name="IDE" id="IDE" required>
                    <option value="">-- Conductor / Mecánico --</option>
                    <?php foreach ($empleados as $e): ?>
                        <option value="<?= $e['IDE'] ?>">
                            <?= htmlspecialchars($e['nombre'] . ' ' . $e['apellidos']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <select name="estado" required>
                    <option value="operativa">🟢 Operativa</option>
                    <option value="mantenimiento">🟠 En mantenimiento</option>
                    <option value="inactiva">🔴 Inactiva</option>
                </select>
            </div>

            <input type="number" name="kilometraje" placeholder="Kilometraje (Km)" required>
            <input type="text" name="numero_serie" placeholder="N° Serie" required>
            <input type="text" name="placa" placeholder="Placa" required>
            <input type="text" name="descripcion" placeholder="Descripción / Detalles" required>

            <button type="submit"><i class="fas fa-save"></i> Guardar</button>
        </form>
    </div>

    <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">ID</th>
                    <th>Empleado Asignado</th>
                    <th>Estado</th>
                    <th>Kilometraje</th>
                    <th>N° Serie</th>
                    <th>Placa</th>
                    <th>Descripción</th>
                    <th style="text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($unidades as $u): ?>
                <tr>
                    <td>#<?= htmlspecialchars($u['IDU']) ?></td>

                    <td>
                        <i class="fas fa-user-tag" style="color:#4db8ff; margin-right:5px;"></i>
                        <?php
                        $emp = $empleado_model->obtenerPorId($u['IDE']);
                        echo $emp ? htmlspecialchars($emp['nombre'] . ' ' . $emp['apellidos']) : '<span style="color:gray; font-style:italic;">Sin asignar</span>';
                        ?>
                    </td>

                    <td>
                        <form action="../controlador/unidades.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_estado">
                            <input type="hidden" name="IDU" value="<?= $u['IDU'] ?>">
                            <select name="estado" onchange="this.form.submit()" 
                                style="color: <?= $u['estado']=='operativa' ? '#00ffaa' : ($u['estado']=='mantenimiento' ? '#ffaa00' : '#ff4d4d') ?>;">
                                <option value="operativa"     <?= $u['estado']=='operativa' ? 'selected':'' ?>>Operativa</option>
                                <option value="mantenimiento" <?= $u['estado']=='mantenimiento' ? 'selected':'' ?>>Mantenimiento</option>
                                <option value="inactiva"      <?= $u['estado']=='inactiva' ? 'selected':'' ?>>Inactiva</option>
                            </select>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/unidades.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_kilometraje">
                            <input type="hidden" name="IDU" value="<?= $u['IDU'] ?>">
                            <input type="number" name="kilometraje" value="<?= htmlspecialchars($u['kilometraje']) ?>">
                            <button type="submit" title="Guardar"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/unidades.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_numero_serie">
                            <input type="hidden" name="IDU" value="<?= $u['IDU'] ?>">
                            <input type="text" name="numero_serie" value="<?= htmlspecialchars($u['numero_serie']) ?>">
                            <button type="submit" title="Guardar"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/unidades.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_placa">
                            <input type="hidden" name="IDU" value="<?= $u['IDU'] ?>">
                            <input type="text" name="placa" value="<?= htmlspecialchars($u['placa']) ?>" style="font-weight:bold; text-transform:uppercase;">
                            <button type="submit" title="Guardar"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/unidades.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_descripcion">
                            <input type="hidden" name="IDU" value="<?= $u['IDU'] ?>">
                            <input type="text" name="descripcion" value="<?= htmlspecialchars($u['descripcion'] ?? '') ?>">
                            <button type="submit" title="Guardar"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td style="text-align: center;">
                        <form action="../controlador/unidades.php" method="POST" style="justify-content: center;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="IDU" value="<?= $u['IDU'] ?>">
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta unidad y todo su historial?')" title="Eliminar">
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