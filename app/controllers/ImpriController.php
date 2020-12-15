<?php
    use Spipu\Html2Pdf\Html2Pdf;

    function descargarHorario()
   {

         $horario = new TramosModel();
         $horario = $horario->listadoHorario();
         $horario = $horario["datos"];
         


         require 'vendor/autoload.php';

         $parametros = [
            "tituloventana" => "Inicio",
            "horario" => $horario

         ];
         ob_start();
         $this->view->show("horarioDescarga", $parametros);
         $html = ob_get_clean();
         $html2pdf = new Html2Pdf('P', 'A4', 'es', 'true', 'UTF-8');
         $html2pdf->writeHTML($html);
         $html2pdf->output("horario_gimnasio_guitart.pdf"); // Como parámetro opcional nombre de fichero a descargar
         ob_end_clean();


   }
       
?>