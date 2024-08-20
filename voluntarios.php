<?php

session_start();
require 'conexion.php';

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['idusuario'])) {
    header("Location: admin.php");




    exit(); // Asegúrate de detener el script después de la redirección
   
}
$nombre = $_SESSION["usuario"];
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
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/administra.css" rel="stylesheet">
</head>
<?php

require 'conexion.php';
$sql = "SELECT * FROM registros";
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
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Pages</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Login Screens:</h6>
                        <a class="collapse-item" href="login.html">Login</a>
                        <a class="collapse-item" href="register.html">Register</a>
                        <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="charts.html">
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
                        <a class="collapse-item" href="prestamo.php">Lista</a>
                     
                        
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
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

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
        <form
            class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
               
                <div class="input-group-append">
                    
                </div>
            </div>
        </form>

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
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $nombre ?></span>
                    <img class="img-profile rounded-circle"
                        src="img/undraw_profile.svg">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                    aria-labelledby="userDropdown">
               
                    <a class="dropdown-item" href="#">
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
        <div class="row">

        <?php
            $query = "SELECT COUNT(*) AS total FROM registros WHERE estado='no resuelto'";
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
            $query = "SELECT COUNT(*) AS total FROM registros WHERE estado='resuelto'";
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
            Casos Resueltos</div>
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

$query = "SELECT count(*) AS total FROM registros";
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
            $query = "SELECT COUNT(*) AS total FROM registros";
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
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo 0; ?></div>
                                        </div>
                                        <div class="col-auto">
                                        <i class="fas fa-database fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


            <!-- Pending Requests Card Example -->
 
            <div class="card mb-4">
    <div class="card-header"><i class="glyphicon glyphicon-user"></i>Tabla Usuario</div>
    <div class="card-body">
        <form class="form-inline" method="get">
            <div class="form-group">
                <select name="filter" class="form-control" onchange="form.submit()">
                    <option value="0">Filtros de area de trabajo</option>
                    <?php $filter = (isset($_GET['filter']) ? strtolower($_GET['filter']) : NULL);  ?>
                    <option value="psicologia" <?php if ($filter == 'psicologia') { echo 'selected'; } ?>>psicologia</option>
                    <option value="nutrición" <?php if ($filter == 'nutrición') { echo 'selected'; } ?>>nutrición</option>
                </select>
            </div>
        </form>
        <br />
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Telefono</th>
                        <th>Email</th>
                        <th>Area</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($filter) {
                        $sql = mysqli_query($conn, "SELECT * FROM voluntarios WHERE area='$filter' ORDER BY idvoluntarios ASC");
                    } else {
                        $sql = mysqli_query($conn, "SELECT * FROM voluntarios ORDER BY idvoluntarios ASC");
                    }
                    if (mysqli_num_rows($sql) == 0) {
                        echo '<tr><td colspan="8">No hay datos.</td></tr>';
                    } else {
                        while ($row = mysqli_fetch_assoc($sql)) {
                        
                            echo '
                                <tr>
                                    <td>' . $row['name'] . '</td>
                                    <td>' . $row['phone'] . '</td>
                                    <td>' . $row['email'] . '</td>
                                <td>' . $row['area'] . '</td>
                                    <td>
                                        <a href="editar_prestamo.php?id=' . $row['idvoluntarios'] . '" title="Editar" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>';
                                    
                                   
                                        echo'
                                        <a href="prestamo.php?id=' . $row['idvoluntarios'] . '" title="Eliminar" onclick="return confirm(\'Esta seguro de borrar los datos ' . $row['name'] . '?\')" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                    </td>
                                </tr>';
            
                                
                             
         

                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="js/session.js"></script>

                    <style type="text/css">




</style>
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


    <div class="modal fade" id="modalAgregarDato" tabindex="-1" role="dialog" aria-labelledby="modalAgregarDatoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAgregarDatoLabel">Abonar Prestamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Formulario para ingresar los datos -->
                <form action="agregar_dato.php" method="post">
                    <!-- Campo oculto para enviar el ID de la tabla -->
                    <input type="hidden" id="idTabla" name="idTabla">
                    
                    <div class="form-group">
                        <label for="nombre">Dinero:</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" required placeholder="Valor Prestamo" oninput="formatNumber(this)">
                    </div>
                    <!-- Otros campos del formulario -->
                    <!-- ... -->
                    <button type="submit" class="btn btn-primary">Agregar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
$('.btnAbrirModal').on('click', function() {
    $('#modalAgregarDato').modal('show');
});

$('#modalAgregarDato').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var idTabla = button.data('id-tabla'); // Extraer el ID de la tabla de los atributos de datos del botón
    var modal = $(this);
    modal.find('.modal-body #idTabla').val(idTabla); // Asignar el ID de la tabla al campo oculto en el modal
});







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
</script>
    

    
<script>




