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
$query = "SELECT q.*, v.name AS atendido_por 
          FROM quiz_psicologico q 
          LEFT JOIN voluntarios v ON q.atencion = v.idvoluntarios 
          ORDER BY q.id ASC";

// Ejecutar la consulta
$sql = mysqli_query($conn, $query);
if (!$sql) {
    die('Error en la consulta: ' . mysqli_error($conn));
}

// Crear un nuevo objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Configurar el ancho de las columnas
$columnWidths = [20, 15, 30, 10, 20, 25, 15, 15];
foreach (range('A', 'H') as $index => $column) {
    $sheet->getColumnDimension($column)->setWidth($columnWidths[$index]);
}

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

$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

// Añadir encabezados
$headers = ['Nombre', 'Telefono', 'Email', 'Edad', 'Ciudad', 'Resultado', 'Estado',  'Atendido Por'];
foreach ($headers as $index => $header) {
    $sheet->setCellValue(chr(65 + $index) . '1', $header);
}

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
    $sheet->setCellValue('A' . $rowNumber, $row['full_name']);
    $sheet->setCellValue('B' . $rowNumber, $row['phone']);
    $sheet->setCellValue('C' . $rowNumber, $row['email']);
    $sheet->setCellValue('D' . $rowNumber, $row['age']);
    $sheet->setCellValue('E' . $rowNumber, $row['city']);
    $sheet->setCellValue('F' . $rowNumber, $row['result_text']);
    $sheet->setCellValue('G' . $rowNumber, $row['estado']);
    $sheet->setCellValue('H' . $rowNumber, $row['atendido_por']);

    // Aplicar formato a cada fila de datos
    $sheet->getStyle('A' . $rowNumber . ':H' . $rowNumber)->applyFromArray($dataStyle);
    $rowNumber++;
}

// Crear el archivo Excel
$writer = new Xlsx($spreadsheet);
$filename = 'testPsicologico' . date('Y-m-d_H-i-s') . '.xlsx';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
header('Content-Transfer-Encoding: binary');

// Guardar el archivo y enviarlo al navegador
$writer->save('php://output');
exit;
?>
