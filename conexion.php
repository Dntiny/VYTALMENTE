<?php
// Conexión a la base de datos (asegúrate de ajustar estos detalles según tu configuración)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PSICOLOGIA";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>