<?php 
// Definir las credenciales de la base de datos
$servername = "localhost"; // Cambia si tu servidor no es localhost
$username = "root"; // Cambia con tu nombre de usuario
$password = ""; // Cambia con tu contraseña
$database = "psicologia"; // Cambia con el nombre de tu base de datos

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if (isset($_GET['id'])) { 
    $id = (int) $_GET['id'];
    
    // Protege contra inyecciones SQL
    $id = mysqli_real_escape_string($conn, $id);
    
    $sql = "DELETE FROM quiz_nutricional WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('Registro eliminado satisfactoriamente: $id');
                window.location.href = '../testnutricional.php';
              </script>";
    } else {
        echo "<script>
                alert('Registro no fue eliminado: $id');
                window.location.href = '../testnutricional.php';
              </script>";
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
