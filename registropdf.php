<?php
require('fpdf.php');
require('conexion.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los detalles del presupuesto de la base de datos usando el ID proporcionado
    $sql = "SELECT * FROM registros WHERE idregistro = $id";
    
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        class PDF extends FPDF
        {
            // Cabecera de página
            function Header()
            {
                // Logo
                $this->Image('images/logo.png', 10, 6, 30);
                $this->SetFont('Arial', 'B', 15);
                // Título
                $this->Cell(80);
                $this->Cell(30, 10, 'Nombre de la Empresa', 0, 1, 'C');
                $this->Cell(0, 10, utf8_decode( 'Número: 123-456-789'), 0, 1, 'C');
                $this->Cell(0, 10, 'Correo: info@empresa.com', 0, 1, 'C');
                $this->Ln(20);
            }

            // Pie de página
            function Footer()
            {
                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
            }

            // Table Row
            function TableRow($label, $value, $fill)
            {
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(50, 10, utf8_decode($label), 1, 0, 'L', $fill);
                $this->SetFont('Arial', '', 10);
                $this->Cell(0, 10, utf8_decode($value), 1, 1, 'L', $fill);
            }

            // MultiCell Row
            function MultiCellRow($label, $value, $fill)
            {
                $this->SetFont('Arial', 'B', 10);
                $this->Cell(50, 10, utf8_decode($label), 1, 0, 'L', $fill);
                $this->SetFont('Arial', '', 10);
                $this->MultiCell(0, 10, utf8_decode($value), 1, 'L', $fill);
            }
        }

        // Creación del objeto de PDF
        $pdf = new PDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);

        // Datos del registro
        $pdf->SetFillColor(243, 243, 243); // Background color for alternate rows
        $fill = false;
        
        $pdf->TableRow('Nombre:', $row['name'], $fill);
        $fill = !$fill;
        $pdf->TableRow('Teléfono:', $row['phone'], $fill);
        $fill = !$fill;
        $pdf->TableRow('Correo:', $row['email'], $fill);
        $fill = !$fill;
        $pdf->TableRow('Edad:', $row['age'], $fill);
        $fill = !$fill;
        $pdf->TableRow('Región:', $row['departamento'], $fill);
        $fill = !$fill;
        $pdf->TableRow('Ciudad:', $row['ciudad'], $fill);
        $fill = !$fill;
        $pdf->TableRow('Tipo de ayuda:', $row['ayuda'], $fill);
      
        $fill = !$fill;
        $pdf->MultiCellRow('Descripción del Problema:', $row['description'], $fill);

        // Salida del PDF
        $pdf->Output();
    }
}
?>
