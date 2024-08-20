<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <link rel="stylesheet" href="css/admin.css">
</head>
<body class="cover"  style="background-image: url(images/loginFont.gif);">
    <div class="form">
        <img src="images/logo.png" class="avatar" alt="Avatar Image"> 
        <h2 class="form_tittle">Iniciar sesión</h2>
        <form method="post" autocomplete="off" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form_container">
                <div class="form_group">
                    <input type="text" id="user" class="form_input" placeholder=" " required name="username"> 
                    <label for="user" class="form_label">Usuario</label>
                    <samp class="form_line"></samp>
                </div>
                <div class="form_group">
                    <input type="password" id="password" class="form_input" placeholder=" " required name="password">
                    <label for="password" class="form_label">Contraseña</label>
                    <samp class="form_line"></samp>
                </div>
                <input type="submit" value="Iniciar sesión" name="iniciar">
            </div>
        </form>
    </div>
</body>
</html>
<?php
include('conexion.php');
session_start();

if (isset($_POST['iniciar'])) {
    $usuario = $_POST['username'];
    $password = $_POST['password'];

    // Hashear la contraseña ingresada con md5
    $hashed_password = md5($password);

    $sql = "SELECT idusuarios, password FROM usuario WHERE usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password_bd = $row['password'];
        
        // Verificar la contraseña ingresada con la contraseña hasheada almacenada
        if ($hashed_password == $password_bd) {
            $_SESSION['idusuario'] = $row['idusuarios'];
            $_SESSION['usuario'] = $usuario;
            header("Location: administra.php");
            exit();
        } else {
            echo "<script>alert('La contraseña no coincide con el usuario: $usuario');</script>";
        }
    } else {
        echo "<script>alert('Usuario no registrado en la base de datos: $usuario');window.location='admin.php';</script>";
    }
    $stmt->close();
}
?>
