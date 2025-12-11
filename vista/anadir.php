<?php
require_once '../modelo/anadir.php'; 

$mensaje = ""; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['NombreU'];
    $contrasena = $_POST['contrasena'];

    if (agregarUsuario($nombre, $contrasena)) {
        $mensaje = "<i class='fas fa-check-circle'></i> Usuario añadido correctamente."; 
    } else {
        $mensaje = "<i class='fas fa-exclamation-circle'></i> Error al añadir el usuario."; 
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Usuario - Zeta Gas</title>
    <link rel="icon" type="image/png" href="../img/ucvlogo.png">
    <link rel="stylesheet" href="../estilos/anadir.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    
    <div class="form-container">
        <h2><i class="fas fa-user-shield"></i> Nuevo Usuario</h2>

        <?php if ($mensaje != ""): ?>
            <div class="mensaje"><?= $mensaje ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="NombreU" placeholder="Nombre de usuario" required autocomplete="off">
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="contrasena" placeholder="Contraseña segura" required>
            </div>

            <button type="submit">
                <i class="fas fa-save"></i> Guardar usuario
            </button>
        </form>

        <a href="../vista/menu.php" class="btn-volver">
            <i class="fas fa-arrow-left"></i> Volver al menú
        </a>
    </div>

</body>
</html>