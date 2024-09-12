<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

require_once('../../libs/fpdf/fpdf.php');
require_once("../../modelo/ws_sistema.php");

class PDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, utf8_decode('REPORTE DE CALIFICACIONES'), 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }

    function ChapterTitle($title) {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, utf8_decode($title), 0, 1, 'L');
        $this->Ln(5);
    }

    function TableHeader($header) {
        $this->SetFont('Arial', 'B', 10);
        foreach ($header as $col) {
            $this->Cell(95, 7, utf8_decode($col), 1);
        }
        $this->Ln();
    }

    function TableRow($data) {
        $this->SetFont('Arial', '', 10);
        foreach ($data as $col) {
            $this->Cell(95, 6, utf8_decode($col), 1);
        }
        $this->Ln();
    }

    function TotalRow($total) {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(95, 6, utf8_decode('Total'), 1);
        $this->Cell(95, 6, utf8_decode($total), 1);
        $this->Ln();
    }
}

$calificacion_obj = new calificacion();
$result = $calificacion_obj->obtener_todas_calificaciones();

$calificaciones = [];

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $jurado = $row['nom_usuario'] . " " . $row['ape_usuario'];
        $candidata = $row['nom_candidata'] . " " . $row['ape_candidata'];
        $categoria = $row['nom_categoria'];
        $parametro = $row['nom_parametro'];
        $calificacion = $row['calificacion'];
        
        if (!isset($calificaciones[$jurado])) {
            $calificaciones[$jurado] = [];
        }
        if (!isset($calificaciones[$jurado][$candidata])) {
            $calificaciones[$jurado][$candidata] = [];
        }
        if (!isset($calificaciones[$jurado][$candidata][$categoria])) {
            $calificaciones[$jurado][$candidata][$categoria] = [];
        }
        
        $calificaciones[$jurado][$candidata][$categoria][$parametro] = $calificacion;
    }
}

$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

foreach ($calificaciones as $jurado => $candidatas) {
    $pdf->ChapterTitle("Jurado: {$jurado}");
    
    foreach ($candidatas as $candidata => $categorias) {
        $pdf->ChapterTitle("Candidata: {$candidata}");
        $totalCandidata = 0;
        
        foreach ($categorias as $categoria => $parametros) {
            $pdf->ChapterTitle("Categoria: {$categoria}");
            $pdf->TableHeader(['Parámetro', 'Calificación']);
            
            $totalCategoria = 0;
            foreach ($parametros as $parametro => $calificacion) {
                $pdf->TableRow([$parametro, $calificacion]);
                $totalCategoria += $calificacion;
            }
            
            $pdf->TotalRow($totalCategoria);
            $totalCandidata += $totalCategoria;
        }
        
        $pdf->ChapterTitle("Total de la Candidata: {$totalCandidata}");
    }
}

$pdf->Output('D', 'Reporte_Calificaciones.pdf');
?>
