<?php

if (isset($_SESSION['user'])) {
    header('Location: menu.php');
    exit();
}
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
    body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
     height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url('../img/zgasL.jpg'); 
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.login-container {
    background: rgba(0, 25, 70, 0.85);
    padding: 40px 50px;
    border-radius: 15px;
    width: 450px;    
    text-align: center;
    color: white;
    box-shadow: 0 0 15px rgba(0,0,0,0.5);  
}

        .login-container {
            background: rgba(11, 2, 124, 0.7);
            padding: 30px;
            border-radius: 12px;    
            width: 350px;
            text-align: center;
            color: white;
        }

        .logo img {
            width: 140px;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 10px;
            top: 12px;
            color: #000;
        }

        .input-group input {
            width: 100%;
            padding: 10px 10px 10px 35px;
            border-radius: 8px;
            border: none;
            outline: none;
            background: #69c3e1;
            color: #000;
        }

        .btn {
            width: 100%;
            padding: 10px;
            background: #4a70faff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .btn:hover {
            background: #15e67dff;    
        }

        .forgot {
            display: block;
            margin-top: 15px;
            color: #bcd4ff;
            text-decoration: none;
        }

        .forgot:hover {
            text-decoration: underline;
        }
        * {
            box-sizing: border-box;
         }
    </style>
</head>
<body>

<div class="login-container">
    <div class="logo">
    <img src="../../img/zgasLog.png" alt="Zeta Gas Logo">
</div>

    <form action="../../index.php" method="POST">
        <div class="input-group">
            <i class="fa fa-user"></i>
            <input type="text" name="nombreU" placeholder="Usuario" required>
        </div>

        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
        </div>

        <input type="submit" name="login" value="Ingresar" class="btn">

        
    </form>
</div>

</body>
</html> 