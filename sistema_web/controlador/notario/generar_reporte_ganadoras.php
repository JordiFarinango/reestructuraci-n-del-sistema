<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once('../../libs/fpdf/fpdf.php');
require_once("../../modelo/ws_sistema.php");

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('GANADORAS'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    function ChapterTitle($title) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode($title), 0, 1, 'L');
        $this->Ln(5);
    }

    function TableRow($data) {
        $this->SetFont('Arial', '', 10);
        $widths = [95, 30]; // Anchos ajustados para las celdas
        foreach ($data as $index => $col) {
            $this->Cell($widths[$index], 8, utf8_decode($col), 1);
        }
        $this->Ln();    
    }

    function SignatureLine($nombre, $cedula) {
        $this->Ln(20);
        $this->Cell(0, 10, '________________________', 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode('Notario'), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode("{$nombre}"), 0, 1, 'C');
        $this->Cell(0, 10, utf8_decode("{$cedula}"), 0, 1, 'C');
    }
}

// Verificar si la sesión está iniciada
if (!isset($_SESSION['id_usuario'])) {
    echo "Sesión no iniciada";
    exit();
}

// Obtener datos del notario de la sesión
$id_usuario = $_SESSION['id_usuario'];
$usuario_obj = new usuario();
$datos_notario = $usuario_obj->ConsultarDatoNotario($id_usuario);

if (!$datos_notario) {
    echo "Usuario no encontrado";
    exit();
}

$nombre_notario = $datos_notario['nom_usuario'] . ' ' . $datos_notario['ape_usuario'];
$cedula_notario = $datos_notario['ced_usuario'];

$calificacion_obj = new calificacion();
$result = $calificacion_obj->obtener_todas_calificaciones();

$candidatas = [];
$jurados_totales = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $candidata = $row['nom_candidata'] . " " . $row['ape_candidata'];
        $jurado = $row['nom_usuario'] . " " . $row['ape_usuario'];
        $calificacion = $row['calificacion'];
        
        if (!isset($candidatas[$candidata])) {
            $candidatas[$candidata] = 0;
        }
        
        if (!isset($jurados_totales[$candidata])) {
            $jurados_totales[$candidata] = [];
        }

        if (!isset($jurados_totales[$candidata][$jurado])) {
            $jurados_totales[$candidata][$jurado] = 0;
        }

        $candidatas[$candidata] += $calificacion;
        $jurados_totales[$candidata][$jurado] += $calificacion;
    }
}

arsort($candidatas);

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

$roles = [
    "Reina del Cantón Cayambe",
    "Virreina del Cantón Cayambe",
    "Señorita Turismo",
    "Señorita Simpatía"
];

$i = 1;
foreach ($candidatas as $candidata => $total) {
    if ($i <= 4) {
        $pdf->ChapterTitle("{$i}. {$candidata} - {$roles[$i - 1]} - Total: {$total}");
        
        foreach ($jurados_totales[$candidata] as $jurado => $total_jurado) {
            $pdf->TableRow(["{$jurado}", "{$total_jurado}"]);
        }
        $pdf->Ln(5); // Margen entre cada grupo de jurado

    }
    $i++;
}
$pdf->SignatureLine($nombre_notario, $cedula_notario);

$pdf->Output('D', 'Reporte_Ganadoras.pdf');
?>
