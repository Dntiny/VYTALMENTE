<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
include '../conexion.php';
require '../vendor/autoload.php'; // Usar Composer para cargar PHPMailer

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitizar y validar datos
    $name = htmlspecialchars(trim($_POST['name']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
    $age = htmlspecialchars(trim($_POST['age']));
    $dpto = htmlspecialchars(trim($_POST['departamento']));
    $cd = htmlspecialchars(trim($_POST['ciudad']));
    $help = htmlspecialchars(trim($_POST['ayuda']));
    $description = htmlspecialchars(trim($_POST['description']));
    $estado = "no resuelto";

    if ($email === false) {
        echo "<script>alert('El correo electrónico no es válido.'); window.location = 'contact.html';</script>";
        exit;
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO registros (name, phone, email, age, departamento, ciudad, ayuda, description, estado) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }
    $stmt->bind_param("sssisssss", $name, $phone, $email, $age, $dpto, $cd, $help, $description, $estado);

    try {
        if ($stmt->execute()) {
            // Confirmar inserción en la base de datos
            error_log("Datos insertados en la base de datos correctamente.");

            // Configuración de PHPMailer
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'outlook.office365.com';
            $mail->SMTPAuth = true;
            $mail->Username ='mateo308@hotmail.com'; // Utilizar variable de entorno
            $mail->Password = 'dante3005'; // Utilizar variable de entorno
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Envío de correo al administrador
            $mail->setFrom('mateo308@hotmail.com', 'Formulario de Contacto');
            $mail->addAddress('dantiny3005@gmail.com');
            $mail->isHTML(true);
            $mail->Subject = 'Nuevo mensaje de contacto';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; border-radius: 10px;'>
                    <h2 style='color: #333; text-align: center; margin-bottom: 20px;'>Nuevo mensaje de contacto</h2>
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
                            <td style='padding: 10px; border: 1px solid #ccc;'>$email</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border: 1px solid #ccc;'><strong>Edad:</strong></td>
                            <td style='padding: 10px; border: 1px solid #ccc;'>$age</td>
                        </tr>
                        <tr>
                            <td style='padding: 10px; border: 1px solid #ccc;'><strong>Región:</strong></td>
                            <td style='padding: 10px; border: 1px solid #ccc;'>$dpto</td>
                        </tr>
                        <tr>
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
                </div>";

            if ($mail->send()) {
                error_log("Correo enviado al administrador correctamente.");

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
                                    <img src="https://example.com/images/VytalMente.png" alt="Logo" style="max-width: 175px;">
                                    <h1 style="color: #333333;">Confirmación de recepción</h1>
                                    <p>Hola, '.$name.'!</p>
                                    <p>¡Gracias! Hemos recibido tu mensaje y nos pondremos en contacto contigo pronto.</p>
                                    <p>Equipo de soporte</p>
                                    <p>Contact us: <a href="tel:+573208052402">+57 320 8052402</a> | <a href="#">Correo</a></p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </body>
                </html>';

                if ($mail->send()) {
                    error_log("Correo de confirmación enviado al usuario correctamente.");
                    echo "<script>alert('Correo registrado'); window.location = '../contact.html';</script>";
                } else {
                    error_log("Error al enviar el correo de confirmación al usuario: " . $mail->ErrorInfo);
                    echo "<script>alert('Error al enviar el correo de confirmación: " . $mail->ErrorInfo . "');</script>";
                }
            } else {
                error_log("Error al enviar el correo al administrador: " . $mail->ErrorInfo);
                echo "<script>alert('Error al enviar el mensaje al administrador: " . $mail->ErrorInfo . "');</script>";
            }
        } else {
            // Fallo al insertar en la base de datos
            error_log("Error en el registro: " . $stmt->error);
            echo "<script>alert('Error en el registro: " . $stmt->error . "');</script>";
        }
    } catch (Exception $e) {
        // Manejo de excepciones de PHPMailer
        error_log("Excepción al enviar el mensaje: " . $e->getMessage());
        echo "<script>alert('Error al enviar el mensaje: " . $mail->ErrorInfo . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
