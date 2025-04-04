<?php 
// Definir las credenciales de la base de datos
$servername = "127.0.0.1:3306";
$username = "u125709288_root";
$password = "D@nte3005";
$dbname = "u125709288_psicologia";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}

if (isset($_GET['id'])) { 
    $id = (int) $_GET['id'];

    // Protege contra inyecciones SQL utilizando declaraciones preparadas
    $stmt = $conn->prepare("DELETE FROM voluntarios WHERE idvoluntarios = ?");
    
    if ($stmt) {
        $stmt->bind_param('i', $id); // 'i' indica que es un entero
        
        if ($stmt->execute()) {
            echo "<script>
                    alert('Registro eliminado satisfactoriamente: $id');
                    window.location.href = '../voluntarios.php';
                  </script>";
        } else {
            echo "<script>
                    alert('No se pudo eliminar el registro: $id');
                    window.location.href = '../voluntarios.php';
                  </script>";
        }
        
        $stmt->close(); // Cerrar la declaración
    } else {
        // Manejo de errores en la preparación de la consulta
        echo "<script>
                alert('Error en la preparación de la consulta.');
                window.location.href = '../voluntarios.php';
              </script>";
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
