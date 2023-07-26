<?php
require "vendor/autoload.php";
// reference the Dompdf namespace
use Dompdf\Dompdf;

ob_start();
require 'conteudo-pdf.php';
$html = ob_get_clean();


// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4' );

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();