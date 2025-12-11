<?php
session_start();

// Encabezados para evitar caché (Seguridad)
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Verificar sesión
if(!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Menú Principal - Zeta Gas</title>
    <link rel="stylesheet" href="../estilos/menu.css">
    <link rel="icon" type="image/png" href="../img/zeta_gasLog.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <header>
        <div class="logo-container">
            <img src="../img/zgasLog.png" alt="Logo empresa Z gas">
        </div>

        <div class="user-controls">
            <span class="welcome-msg">Hola, <strong><?php echo htmlspecialchars($_SESSION['user']['NombreU']); ?></strong></span>

            <form action="../controlador/salida.php" method="post" style="margin: 0;">
                <button class="logout-button">
                    <i class="fas fa-sign-out-alt"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </header>

    <div class="container">

        <div class="card">
            <a href="../vista/empleado.php">
                <img src="../img/gestionar.png" alt="Gestionar usuarios">
                <p>Registrar empleados</p>
            </a>
        </div>

        <div class="card">
            <a href="../controlador/historial.php">
                <img src="../img/historial.png" alt="Historial">
                <p>Registros de la empresa</p>
            </a>
        </div>

        <div class="card">
            <a href="../vista/unidades.php">
                <img src="../img/camion.png" alt="Registrar unidades">
                <p>Registrar unidades</p>
            </a>
        </div>

       <div class="card">
          <a href="../vista/repuestos.php">
                 <img src="../img/rpuestos.png" alt="Registrar repuestos">
                 <p>Registrar repuestos</p>
          </a>
        </div>

        <div class="card">
            <a href="../vista/anadir.php">
                <img src="../img/anadir.png" alt="Añadir usuario">
                <p>Añadir usuario</p>
            </a>
        </div>

    </div>

    <footer>
        <p>© 2025 Empresa Zeta Gas - Todos los derechos reservados</p>
        <p>RUC: 20262254268 | Teléfono: (01) 3710817</p>
    </footer>

</body>
</html>