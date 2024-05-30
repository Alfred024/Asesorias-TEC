<?php 
    require('../resources/fpdf-1-6-es/fpdf.php');
    if (!class_exists("Class_Database")) include "../classes/class_database.php";

    class PDFS extends Class_Database{
        var $fpdf;
        
        function generateConsultanciesPDF($clave) {
            $fpdf = new FPDF();
            $fpdf->AddPage();
            // $fpdf->SetFont('Arial','B',12);

            $select_query = 
            'SELECT
                concat(usu.nombres," ", usu.apellido_paterno," ", usu.apellido_materno," ") as alumno,
                ase.competencia,
                ase.tema,
                ase.descripcion,
                ase.fecha
            FROM asesoria AS ase
            JOIN usuario AS usu ON ase.id_usuario_toma = usu.id_usuario
            WHERE ase.clave = "'.$clave.'" ';

            $this->getRecord($select_query);
            if($this->registersNum > 0){

                // campos de la tabla
                $campos=array();
                $this->getFields($campos);
                foreach($campos as $campo){
                    $fpdf->Cell(46,12,$campo,1);
                }
                $fpdf->Ln();
                
                // Pasar el valor de los campos
                $consultancies = '';
                foreach ($this->registrersBlock as $registerRow) {
                    $fpdf->Cell(46,12,$registerRow["alumno"],1);
                    $fpdf->Cell(46,12,$registerRow["competencia"],1);
                    $fpdf->Cell(46,12,$registerRow["tema"],1);
                    $fpdf->Cell(46,12,$registerRow["descripcion"],1);
                    $fpdf->Cell(46,12,$registerRow["fecha"],1);
                    $fpdf->Ln();
                }
            }
            $fpdf->Output();
        }
    }

    $pdf = new PDFS();
    if(isset($_REQUEST['id'])){
        $pdf->generateConsultanciesPDF($_REQUEST['id']);
    }
?>
