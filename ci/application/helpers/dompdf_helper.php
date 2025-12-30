<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');


use Dompdf\Dompdf;

function pdf_create($html, $filename='', $stream=TRUE) 
{

  $dompdf = new Dompdf();
  
  $dompdf->loadHtml($html);
  $dompdf->render();
  if ($stream) {
    $dompdf->stream($filename.".pdf");
  } else {
    return $dompdf->output();
  }
}
function pdf_create1($html, $filename='', $stream=TRUE, $path = false) 
{
  $dompdf = new Dompdf();  

  $dompdf->loadHtml($html);    
  $dompdf->render();
  $pdf = $dompdf->output();

  if($path) $file_location = $path.$filename.".pdf";
  else
    $file_location = "uploads/invoice/".$filename.".pdf";

  file_put_contents($file_location, $pdf); 
}
