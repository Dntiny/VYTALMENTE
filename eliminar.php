<?php 

require 'conexion.php';
if(isset($_GET['id'])){ 
	$id=(int) $_GET['id'];
	
	$sql = "DELETE FROM registros WHERE idregistro=$id";
if (mysqli_query($conn, $sql)) {
    echo "<script> alert('Registro eliminado satisfactoriamente : $id'); </script>";
} else {
    echo "<script> alert('Registro no fue eliminado satisfactoriamente : $id'); </script>";
}
}


 ?>
 