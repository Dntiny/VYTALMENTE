<?php
header("Content-Type: application/json; charset=UTF-8");
require "conexion.php";

try {
    // Obtener los datos enviados
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        $fullName = $data['fullName'];
        $age = $data['age'];
        $city = $data['city'];
        $phone = $data['phone'];
        $email = $data['email'];
        $height = $data['height'];
        $weight = $data['weight'];
        $bmi = $data['bmi'];
        $score = $data['score'];
        $resultText = $data['resultText'];
        $ayuda = "nutricional";
        $estado = "no resuelto";

        // Preparar la consulta SQL
        $stmt = $conn->prepare("INSERT INTO quiz_nutricional (full_name, age, city, phone, email, height, weight, bmi, score, result_text, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            // Enlazar los parámetros
            $stmt->bind_param('sisssdddiss', $fullName, $age, $city, $phone, $email, $height, $weight, $bmi, $score, $resultText, $estado);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al insertar los datos: " . $stmt->error]);
            }

            // Cerrar la declaración
            $stmt->close();
        } else {
            echo json_encode(["success" => false, "message" => "Error al preparar la consulta: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "No se recibieron datos."]);
    }
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => "Excepción: " . $e->getMessage()]);
}

$conn->close();
?>
