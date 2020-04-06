<?php

require '../vendor/autoload.php';

// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml(file_get_contents('sample.html'));

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('a4', 'portrait');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("samplepdf1", [
    "Attachment" => false
]);
