<?php 

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
    $id = (int) $_GET['id']; // Asegurarse de que $id sea un entero

    // Preparar la consulta SQL para verificar si el registro existe
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM registros WHERE idregistro = ?");
    
    if ($checkStmt) {
        $checkStmt->bind_param('i', $id);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($count > 0) {
            // Preparar la consulta SQL para eliminar el registro
            $stmt = $conn->prepare("DELETE FROM registros WHERE idregistro = ?");
            
            if ($stmt) {
                $stmt->bind_param('i', $id); // 'i' indica que es un entero

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    echo "<script>
                            alert('Registro eliminado satisfactoriamente: $id');
                            window.location.href = '../administra.php';
                          </script>";
                } else {
                    echo "<script>
                            alert('No se pudo eliminar el registro: $id');
                          </script>";
                }
                
                $stmt->close(); // Cerrar la declaración
            } else {
                echo "<script>
                        alert('Error en la preparación de la consulta.');
                      </script>";
            }
        } else {
            echo "<script>
                    alert('No se encontró el registro: $id');
                  </script>";
        }
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conn);
?>
