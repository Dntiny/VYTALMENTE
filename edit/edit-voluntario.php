
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
require '../conexion.php';



// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['idusuario'])) {
    header("Location: admin.php");
    exit(); // Asegúrate de detener el script después de la redirección
}

// Obtiene el nombre de usuario de la sesión
$nombre = $_SESSION["usuario"];






// Verifica si se ha enviado el ID del usuario
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Obtener los datos del usuario
    $query = "SELECT * FROM voluntarios WHERE idvoluntarios = $user_id";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        $user_name = $user['name'];
        $user_phone = $user['phone'];
        $user_email = $user['email'];
        $user_area = $user['area'];
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Manejar el formulario de actualización
if (isset($_POST['btnActualizar'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $area = $_POST['area'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $query = "UPDATE voluntarios SET name = '$name', area = '$area', phone = '$phone', email = '$email' WHERE idvoluntarios = $id";

    if (mysqli_query($conn, $query)) {
        echo "<script> alert('Voluntario actualizado'); window.location = '../voluntarios.php'; </script>";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
    }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>VytalMente - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/administra.css" rel="stylesheet">
</head>
<?php

require '../conexion.php';
$sql = "SELECT * FROM voluntarios ";
$resultado = mysqli_query($conn, $sql);
$mostrar = mysqli_fetch_array($resultado);


?>

<body id="page-top">
<script>
		function eliminar() {
			var respuesta = confirm("ESTAS SEGURO QUE DESEAS ELIMINAR")
			return respuesta
		}
	</script>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">VytalMente <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="administra.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
           

            <!-- Nav Item - Utilities Collapse Menu -->


            <!-- Divider -->
    

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
   

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="promedio.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages1"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-database"></i>
                    <span>Registros</span>
                </a>
                <div id="collapsePages1" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Registros screen:</h6>
                        <a class="collapse-item" href="administra.php">Lista</a>
                     
                        
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages2"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-user"></i>
                    <span>Voluntarios</span>
                </a>
                <div id="collapsePages2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Voluntarios screen:</h6>
                        <a class="collapse-item" href="voluntarios.php">Lista</a>
                        <a class="collapse-item" href="crear_voluntarios.php">Nuevo</a>
                        
                    </div>
                </div>
            </li>
            <!-- Nav Item - Tables -->
         

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
            <!-- Sidebar Message -->
         
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">

<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
        </button>

        <!-- Topbar Search -->
     

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
                <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-search fa-fw"></i>
                </a>
                <!-- Dropdown - Messages -->
                <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                    aria-labelledby="searchDropdown">
                    <form class="form-inline mr-auto w-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small"
                                placeholder="Search for..." aria-label="Search"
                                aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li>
  


            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombre?></span>
                    <img class="img-profile rounded-circle"
                        src="img/undraw_profile.svg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="editar_usuarios.php">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Settings
                    </a>
                
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </a>
                </div>
            </li>

        </ul>

    </nav>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            
        </div>

        <!-- Content Row -->
        <div class="container-fluid">


<!-- Content Row -->
<div class="row">

<?php
    $query = "SELECT COUNT(*) AS total FROM quiz_nutricional";
$result = $conn->query($query);

// Verificar si la consulta fue exitosa
if ($result) {
$row = $result->fetch_assoc();
$totalData = $row['total'];
} else {
// Manejar el caso en que la consulta no fue exitosa
$totalData = "Error en la consulta";
}


?>

<div class="col-xl-3 col-md-6 mb-4">
<div class="card border-left-primary shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
    Casos Sin Resolver</div>
<div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo$totalData ?></div>
</div>
<div class="col-auto">
<i class="fas fa-database fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>



<?php
    $query = "SELECT COUNT(*) AS total FROM quiz_nutricional";
$result = $conn->query($query);

// Verificar si la consulta fue exitosa
if ($result) {
$row = $result->fetch_assoc();
$totalData = $row['total'];
} else {
// Manejar el caso en que la consulta no fue exitosa
$totalData = "Error en la consulta";
}


?>

<div class="col-xl-3 col-md-6 mb-4">
<div class="card border-left-success shadow h-100 py-2">
<div class="card-body">
<div class="row no-gutters align-items-center">
<div class="col mr-2">
<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
    Test Nutricional</div>
<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalData; ?></div>
</div>
<div class="col-auto">
<i class="fas fa-database fa-2x text-gray-300"></i>
</div>
</div>
</div>
</div>
</div>
<?php

$query = "SELECT count(*) AS total FROM quiz_nutricional ";
$result = mysqli_query($conn, $query);

// Verificar si la consulta fue exitosa
if ($result) {
$row = mysqli_fetch_assoc($result);
$totalEarnings = $row['total'];
} else {
// Manejar el caso en que la consulta no fue exitosa
$totalEarnings = "Error en la consulta";
}

// Cerrar la conexión a la base de datos si es necesario
// ...

?>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Registros Totales
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $totalEarnings ?></div>
                                        </div>
                                        <div class="col">
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                <i class="fas fa-database fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
    $query = "SELECT COUNT(*) AS total FROM voluntarios";
$result = $conn->query($query);

// Verificar si la consulta fue exitosa
if ($result) {
$row = $result->fetch_assoc();
$totalData = $row['total'];
} else {
// Manejar el caso en que la consulta no fue exitosa
$totalData = "Error en la consulta";
}


?>
                <!-- Pending Requests Card Example -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Total Voluntarios</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalData; ?></div>
                                </div>
                                <div class="col-auto">
                                <i class="fas fa-database fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
    <div class="card-header"><i></i> Editar Voluntario</div>
    <div class="card-body">
        <div class="modal-body">
            <form id="frm" method="POST" autocomplete="off">
                <!-- Campo oculto para el ID del usuario -->
                <input type="hidden" name="id" value="<?php echo $user_id; ?>">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="afirmacion">Area</label>
                            <select id="responsable" class="form-control" name="area" required>
                                <option disabled hidden>SELECCIONAR AREA DE TRABAJO</option>
                                <option value="Psicologia" <?php echo ($user_area == 'Psicologia') ? 'selected' : ''; ?>>Psicologia</option>
                                <option value="Nutricion" <?php echo ($user_area == 'Nutricion') ? 'selected' : ''; ?>>Nutricion</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="number">Nombre del Voluntario</label>
                            <input id="price" class="form-control" type="text" name="name" required placeholder="Nombre" value="<?php echo $user_name; ?>">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="number">Numero</label>
                            <input id="documento" class="form-control" type="number" name="phone" required placeholder="Numero Telefonico" value="<?php echo $user_phone; ?>">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="number">Correo</label>
                            <input id="email" class="form-control" type="email" name="email" required placeholder="Correo Responsable" value="<?php echo $user_email; ?>">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="btnActualizar" id="btnAccion">Actualizar</button>
                            <button class="btn btn-danger" type="button" onclick="window.location.href='../voluntarios.php'">Cancelar</button>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">¿Listo Para Irte?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecciona "Logout" si estas listo para cerrar sesion.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script>
function formatNumber(input) {
    // Obtener el valor actual del campo de entrada
    let inputValue = input.value;

    // Remover cualquier formato existente y caracteres no numéricos
    let unformattedValue = inputValue.replace(/[^\d]/g, '');

    // Aplicar formato con puntos como separadores de miles
    let formattedValue = unformattedValue.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Actualizar el valor del campo de entrada con el nuevo formato
    input.value = formattedValue;
}
</script>

<script>
    // Define una función en JavaScript para limpiar el formulario
    function limpiarFormulario() {
        // Obtiene una referencia al formulario por su ID
        var formulario = document.getElementById("frm");
        
        // Recorre todos los elementos del formulario y los limpia
        for (var i = 0; i < formulario.elements.length; i++) {
            var elemento = formulario.elements[i];
            
            // Limpia los campos de texto, área de texto y restablece los campos de selección
            if (elemento.type === "text" || elemento.tagName === "TEXTAREA" || elemento.tagName === "SELECT") {
                elemento.value = "";
            }
            // Restablece los campos de radio y casillas de verificación
            else if (elemento.type === "radio" || elemento.type === "checkbox") {
                elemento.checked = false;
            }
        }
    }










</script>
<script src="js/session.js"></script>


  