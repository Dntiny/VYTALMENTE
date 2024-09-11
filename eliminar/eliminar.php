<?php 

$servername = "localhost"; // Cambia si tu servidor no es localhost
$username = "root"; // Cambia con tu nombre de usuario
$password = ""; // Cambia con tu contraseña
$database = "psicologia"; // Cambia con el nombre de tu base de datos

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $database);

if(isset($_GET['id'])){ 
	$id=(int) $_GET['id'];
	
	$sql = "DELETE FROM registros WHERE idregistro=$id";
if (mysqli_query($conn, $sql)) {
    echo "<script> alert('Registro eliminado satisfactoriamente : $id');  window.location.href = '../administra.php'; </script>";
} else {
    echo "<script> alert('Registro no fue eliminado satisfactoriamente : $id'); </script>";
}
}


 ?>
 