<?php
header("Content-Type: application/json; charset=UTF-8");
require "../conexion.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Asegúrate de tener PHPMailer instalado y esta ruta correcta

try {
    // Obtener los datos enviados
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data) {
        // Datos del formulario
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
        $estado = "no resuelto";

        // Preparar la consulta SQL para insertar los datos
        $stmt = $conn->prepare("INSERT INTO quiz_nutricional (full_name, age, city, phone, email, height, weight, bmi, score, result_text, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt) {
            // Enlazar los parámetros
            $stmt->bind_param('sisssdddiss', $fullName, $age, $city, $phone, $email, $height, $weight, $bmi, $score, $resultText, $estado);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                // Obtener el ID del último registro insertado
                $lastId = $conn->insert_id;
                
                // Generar el case_number solo numérico (sin prefijo "CASE")
                $caseNumber = str_pad($lastId, 4, "0", STR_PAD_LEFT);
                
                // Actualizar el registro con el case_number
                $updateStmt = $conn->prepare("UPDATE quiz_nutricional SET case_number = ? WHERE id = ?");
                if ($updateStmt) {
                    $updateStmt->bind_param('si', $caseNumber, $lastId);
                    if ($updateStmt->execute()) {
                        // Datos de la respuesta
                        $response = ["success" => true, "case_number" => $caseNumber];
                        
                        // Configuración de PHPMailer
                        $mail = new PHPMailer(true);
                        $mail->isSMTP();
                        $mail->Host = 'outlook.office365.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'mateo308@hotmail.com'; // Utilizar variable de entorno
                        $mail->Password = 'dante3005'; // Utilizar variable de entorno
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Envío de correo al administrador
                        $mail->setFrom('mateo308@hotmail.com', 'Formulario de Contacto');
                        $mail->addAddress('dantiny3005@gmail.com');
                        $mail->isHTML(true);
                        $mail->Subject = 'Nuevo mensaje de TestNutricional';
                        $mail->Body = "
                        
                                                    <div style='font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; border-radius: 10px;'>
                                <h2 style='color: #333; text-align: center; margin-bottom: 20px;'>Nuevo mensaje de contacto</h2>
                                <table style='width: 100%; border-collapse: collapse;'>
                                    <tr style='background-color: #f3f3f3;'>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Nombre:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$fullName</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Teléfono:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$phone</td>
                                    </tr>
                                    <tr style='background-color: #f3f3f3;'>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Correo:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$email</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Edad:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$age</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Altura:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$height</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Peso:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$weight</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Índice de Masa Corporal:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$bmi</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Puntuación:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$score</td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 10px; border: 1px solid #ccc;'><strong>Texto del Resultado:</strong></td>
                                        <td style='padding: 10px; border: 1px solid #ccc;'>$resultText</td>
                                    </tr>
                                </table>
                            </div>";

                        if ($mail->send()) {
                            // Envío de correo al usuario
                            $mail->clearAddresses(); // Limpiar direcciones anteriores
                            $mail->addAddress($email);
                            $mail->Subject = 'Confirmación de recepción de mensaje';
                            $mail->Body = '
                            <html>
                            <head>
                               
                                <meta charset="UTF-8">
                                <meta name="viewport" content="width=device-width, initial-scale=1">
                                <title>Confirmación de recepción</title>
                            </head>
                            <body>
                                <div style="font-family: Arial, sans-serif; background-color: #fafafa; padding: 20px;">
                                    <table style="width: 100%; max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px;">
                                        <tr>
                                            <td style="text-align: center;">
                                                <img src="http://localhost/vitalmente/images/logo.png" alt="Logo" style="max-width: 175px;">
                                                <h1 style="color: #333333;">Confirmación de recepción</h1>
                                                <p>Hola, '.$fullName.'!</p>
                                                <p>¡Gracias! Hemos recibido tu mensaje y nos pondremos en contacto contigo pronto.</p>
                                                <p>Equipo de soporte</p>
                                                <p>Contact us: <a href="tel:+573208052402">+57 320 8052402</a> | <a href="mailto:dsmosquera@miuniclaretiana.edu.co">Correo</a></p>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </body>
                            </html>';

                            if ($mail->send()) {
                                $response['message'] = 'Correo de confirmación enviado al usuario correctamente.';
                            } else {
                                $response['message'] = 'Error al enviar el correo de confirmación al usuario: ' . $mail->ErrorInfo;
                            }
                        } else {
                            $response['message'] = 'Error al enviar el correo al administrador: ' . $mail->ErrorInfo;
                        }

                        // Devolver respuesta JSON
                        echo json_encode($response);
                    } else {
                        echo json_encode(["success" => false, "message" => "Error al actualizar el case_number: " . $updateStmt->error]);
                    }
                    $updateStmt->close();
                } else {
                    echo json_encode(["success" => false, "message" => "Error al preparar la consulta de actualización: " . $conn->error]);
                }
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
