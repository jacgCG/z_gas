<?php
require_once "../modelo/empleado.php";
$empleado = new Empleado();
$empleados = $empleado->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Empleados - Zeta Gas</title>
    <link rel="stylesheet" href="../estilos/empleado.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>

<div class="contenido">

    <div class="botones-superior">
        <h2><i class="fas fa-users-cog"></i> Gestión de Empleados</h2>
        <div>
            <a href="menu.php" class="btn-nav"><i class="fas fa-arrow-left"></i> Menú</a>
            <a href="unidades.php" class="btn-nav">Unidades <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="seccion-agregar">
        <h3><i class="fas fa-user-plus"></i> Agregar nuevo empleado</h3>
        <form class="form-registro" action="../controlador/empleado.php" method="POST">
            <input type="hidden" name="accion" value="crear">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="apellidos" placeholder="Apellidos" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <select name="tipoE">
                <option value="mecanico">Mecánico</option>
                <option value="conductor">Conductor</option>
            </select>
            <button type="submit"><i class="fas fa-save"></i> Guardar</button>
        </form>
    </div>

    <div class="tabla-contenedor">
        <table>
            <thead>
                <tr>
                    <th style="width: 5%;">ID</th>
                    <th style="width: 15%;">Nombre</th>
                    <th style="width: 20%;">Apellidos</th>
                    <th style="width: 20%;">Correo</th>
                    <th style="width: 15%;">Teléfono</th>
                    <th style="width: 15%;">Rol</th>
                    <th style="width: 10%; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($empleados as $emp): ?>
                <tr>
                    <td>#<?= $emp['IDE'] ?></td>

                    <td>
                        <form action="../controlador/empleado.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_nombre">
                            <input type="hidden" name="IDE" value="<?= $emp['IDE'] ?>">
                            <input type="text" name="nombre" value="<?= htmlspecialchars($emp['nombre']) ?>">
                            <button type="submit" title="Guardar cambio"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/empleado.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_apellidos">
                            <input type="hidden" name="IDE" value="<?= $emp['IDE'] ?>">
                            <input type="text" name="apellidos" value="<?= htmlspecialchars($emp['apellidos']) ?>">
                            <button type="submit" title="Guardar cambio"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/empleado.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_correo">
                            <input type="hidden" name="IDE" value="<?= $emp['IDE'] ?>">
                            <input type="email" name="correo" value="<?= htmlspecialchars($emp['correo']) ?>">
                            <button type="submit" title="Guardar cambio"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/empleado.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_telefono">
                            <input type="hidden" name="IDE" value="<?= $emp['IDE'] ?>">
                            <input type="text" name="telefono" value="<?= htmlspecialchars($emp['telefono']) ?>">
                            <button type="submit" title="Guardar cambio"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td>
                        <form action="../controlador/empleado.php" method="POST">
                            <input type="hidden" name="accion" value="actualizar_tipoE">
                            <input type="hidden" name="IDE" value="<?= $emp['IDE'] ?>">
                            <select name="tipoE" onchange="this.form.submit()"> <option value="mecanico" <?= $emp['tipoE'] == 'mecanico' ? 'selected' : '' ?>>Mecánico</option>
                                <option value="conductor" <?= $emp['tipoE'] == 'conductor' ? 'selected' : '' ?>>Conductor</option>
                            </select>
                            <button type="submit" title="Guardar cambio"><i class="fas fa-save"></i></button>
                        </form>
                    </td>

                    <td style="text-align: center;">
                        <form action="../controlador/empleado.php" method="POST" style="justify-content: center;">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="IDE" value="<?= $emp['IDE'] ?>">
                            <button type="submit" class="btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar a este empleado?')" title="Eliminar usuario">
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