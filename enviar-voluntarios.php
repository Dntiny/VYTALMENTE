<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('conexion.php');
require 'vendor/autoload.php'; // Cargar Composer y PHPMailer

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idTabla = $_POST['idTabla'];
    $voluntario = $_POST['voluntario'];
    $estado = "en proceso"; // El estado es una cadena de texto

    // Consulta para obtener los datos del registro
    $sql1 = "SELECT * FROM registros WHERE idregistro=?";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("i", $idTabla);

  

    if ($stmt1 = $conn->prepare("SELECT * FROM registros WHERE idregistro=?")) {
        $stmt1->bind_param("i", $idTabla);
        if ($stmt1->execute()) {
            $result = $stmt1->get_result();
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $sql3 = "SELECT * FROM voluntarios WHERE idvoluntarios=?";
                if ($stmt3 = $conn->prepare($sql3)) {
                    $stmt3->bind_param("i", $voluntario);
                    $stmt3->execute();
                    $result1 = $stmt3->get_result();
                    $row1 = $result1->fetch_assoc();
    
                    // Obtener los datos del registro
                    $name = $row['name'];
                    $phone = $row['phone'];
                    $age = $row['age'];
                    $dpto = $row['departamento'];
                    $cd = $row['ciudad'];
                    $help = $row['ayuda'];
                    $description = $row['description'];
                    $email = $row1['email'];
                    $emailclient=$row["email"];

            // Actualizar el registro con los nuevos datos
            $sql2 = "UPDATE registros SET estado=?, atencion=? WHERE idregistro=?";
            $stmt2 = $conn->prepare($sql2);

            if ($stmt2 === false) {
                die('Prepare failed: ' . htmlspecialchars($conn->error));
            }

            $stmt2->bind_param("sii", $estado, $voluntario, $idTabla);

            if ($stmt2->execute()) {
                echo "Registro actualizado exitosamente.";
                
                // Enviar correo con PHPMailer
                $mail = new PHPMailer(true);

                try {
                    // Configuración del servidor SMTP
                    $mail->isSMTP();
                    $mail->Host = 'outlook.office365.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'mateo308@hotmail.com';
                    $mail->Password = 'dante3005';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Destinatarios
                    $mail->setFrom('mateo308@hotmail.com', 'Formulario de Contacto');
                    $mail->addAddress($email); // Enviar el correo al email obtenido del registro

                    // Contenido del correo
                    $mail->isHTML(true);
                    $mail->Subject = '  Petición de Contacto';
                    $mail->Body = " <html>
                    <head>
                        <meta charset='UTF-8'>
                    </head>
                    <body>
                        <div style='font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; border-radius: 10px;'>
                            <h2 style='color: #333; text-align: center; margin-bottom: 20px;'>Actualización de Registro</h2>
                            <table style='width: 100%; border-collapse: collapse;'>
                                <tr style='background-color: #f3f3f3;'>
                                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Nombre:</strong></td>
                                    <td style='padding: 10px; border: 1px solid #ccc;'>$name</td>
                                </tr>
                                <tr>
                                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Teléfono:</strong></td>
                                    <td style='padding: 10px; border: 1px solid #ccc;'>$phone</td>
                                </tr>
                                <tr style='background-color: #f3f3f3;'>
                                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Correo:</strong></td>
                                    <td style='padding: 10px; border: 1px solid #ccc;'>$emailclient</td>
                                </tr>
                                <tr>
                                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Edad:</strong></td>
                                    <td style='padding: 10px; border: 1px solid #ccc;'>$age</td>
                                </tr>
                                <tr>
                                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Región:</strong></td>
                                    <td style='padding: 10px; border: 1px solid #ccc;'>$dpto</td>
                                </tr>
                                <tr style='background-color: #f3f3f3;'>
                                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Ciudad:</strong></td>
                                    <td style='padding: 10px; border: 1px solid #ccc;'>$cd</td>
                                </tr>
                                <tr>
                                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Tipo de ayuda:</strong></td>
                                    <td style='padding: 10px; border: 1px solid #ccc;'>$help</td>
                                </tr>
                                <tr>
                                    <td style='padding: 10px; border: 1px solid #ccc;'><strong>Descripción del Problema:</strong></td>
                                    <td style='padding: 10px; border: 1px solid #ccc;'>$description</td>
                                </tr>
                            </table>
                        </div>
                    </body>
                    </html>";

                    $mail->send();
                    echo "<script>alert('Correo registrado'); window.location = 'administra.php';</script>";
                } catch (Exception $e) {
                    echo "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
                }
            } else {
                echo "Error al actualizar el registro.";
            }

            $stmt2->close();
        } else {
            echo "No se encontró el registro con el ID especificado.";
        }
    } else {
        echo "Error al ejecutar la consulta.";
    }


    $stmt1->close();
    $conn->close();
}
    }
}
?>
