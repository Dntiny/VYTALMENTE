<?php
// Conexión a la base de datos (asegúrate de ajustar estos detalles según tu configuración)
$servername = "127.0.0.1:3306";
$username = "u125709288_root";
$password = "D@nte3005";
$dbname = "u125709288_psicologia";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>