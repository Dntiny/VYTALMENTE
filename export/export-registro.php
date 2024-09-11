<?php
require '../vendor/autoload.php'; // Asegúrate de que el camino sea correcto
require '../conexion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Conexión a la base de datos
if (!$conn) {
    die('No se pudo conectar a la base de datos: ' . mysqli_connect_error());
}

// Construir la consulta SQL
$query = "SELECT * FROM registros ORDER BY idregistro ASC";


// Ejecutar la consulta
$sql = mysqli_query($conn, $query);
if (!$sql) {
    die('Error en la consulta: ' . mysqli_error($conn));
}

// Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar el ancho de las columnas
$sheet->getColumnDimension('A')->setWidth(20);
$sheet->getColumnDimension('B')->setWidth(15);
$sheet->getColumnDimension('C')->setWidth(30);
$sheet->getColumnDimension('D')->setWidth(10);
$sheet->getColumnDimension('E')->setWidth(20);
$sheet->getColumnDimension('F')->setWidth(25);
$sheet->getColumnDimension('G')->setWidth(15);
$sheet->getColumnDimension('H')->setWidth(15);
$sheet->getColumnDimension('I')->setWidth(10);
$sheet->getColumnDimension('J')->setWidth(15);

// Aplicar color de fondo y alinear el texto de los encabezados
$headerStyle = [
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'color' => ['argb' => 'FF006400'], // Color de fondo verde oscuro
    ],
    'font' => [
        'bold' => true,
        'color' => ['argb' => 'FFFFFFFF'], // Color del texto blanco
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
    ],
];

$sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

// Añadir encabezados
$sheet->setCellValue('A1', 'Nombre');
$sheet->setCellValue('B1', 'Correo');
$sheet->setCellValue('C1', 'Telefono');
$sheet->setCellValue('D1', 'Departamento');
$sheet->setCellValue('E1', 'Ciudad');
$sheet->setCellValue('F1', 'Edad');
$sheet->setCellValue('G1', 'Descripción');
$sheet->setCellValue('H1', 'Estado');
$sheet->setCellValue('I1', 'Ayuda');
$sheet->setCellValue('J1', 'Atendido Por');

// Aplicar formato a las celdas de datos
$dataStyle = [
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

// Añadir datos
$rowNumber = 2;
while ($row = mysqli_fetch_assoc($sql)) {
    $query1 = "SELECT * FROM voluntario where idvoluntarios='$idvoluntario'";


    
    $sheet->setCellValue('A' . $rowNumber, $row['name']);
    $sheet->setCellValue('B' . $rowNumber, $row['email']);
    $sheet->setCellValue('C' . $rowNumber, $row['phone']);
    $sheet->setCellValue('D' . $rowNumber, $row['departamento']);
    $sheet->setCellValue('E' . $rowNumber, $row['ciudad']);
    $sheet->setCellValue('F' . $rowNumber, $row['age']);
    $sheet->setCellValue('G' . $rowNumber, $row['description']);
    $sheet->setCellValue('H' . $rowNumber, $row['estado']);
    $sheet->setCellValue('I' . $rowNumber, $row['ayuda']);
    $sheet->setCellValue('J' . $rowNumber, $row['atencion']);

    // Aplicar formato a cada fila de datos
    $sheet->getStyle('A' . $rowNumber . ':J' . $rowNumber)->applyFromArray($dataStyle);
    $rowNumber++;
}

// Crear el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'RegistrodeAyuda_' . date('Y-m-d_H-i-s') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Guardar el archivo y enviarlo al navegador
$writer->save('php://output');
exit;
?>
