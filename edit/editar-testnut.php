<?php
// Incluye tu archivo de conexión a la base de datos
include('../conexion.php');

// Verifica que el formulario se haya enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén el ID de la tabla y el nuevo estado del formulario
    $idTabla = $_POST['idTabla'];
    $estado = $_POST['estado'];

    // Verifica que el ID y el estado no estén vacíos
    if (!empty($idTabla) && !empty($estado)) {
        // Prepara la consulta SQL para actualizar el estado
        $sql = "UPDATE quiz_nutricional SET estado = ? WHERE id = ?";
        
        // Prepara la declaración
        if ($stmt = $conn->prepare($sql)) {
            // Vincula las variables a la declaración preparada
            $stmt->bind_param("si", $estado, $idTabla);

            // Ejecuta la declaración
            if ($stmt->execute()) {
                // Redirige o muestra un mensaje de éxito
                header("Location: ../testnutricional.php"); // Redirige a una página de éxito o muestra un mensaje
            } else {
                // Muestra un mensaje de error
                echo "Error al actualizar el estado: " . $stmt->error;
            }

            // Cierra la declaración
            $stmt->close();
        } else {
            // Muestra un mensaje de error
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    } else {
        // Muestra un mensaje de error si faltan campos
        echo "ID de la tabla o estado vacío.";
    }
}

// Cierra la conexión
$conn->close();
?>
