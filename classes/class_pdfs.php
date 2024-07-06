<?php 
    require('../resources/fpdf186/fpdf.php');
    if (!class_exists("Class_Database")) include "../classes/class_database.php";

    class PDFS extends Class_Database{
        var $fpdf;
        
        function setHeader($fpdf, $clave) {
            $this->getSignatureName($clave);
            $signature_name = $this->getSignatureName($clave);
            
            $fpdf->SetFont('Arial','B',16);
            $fpdf->Image('../assets/LOGO-VERTICAL-TECNM.png', 10, 6, 27);
            $fpdf->Cell(30);
            $fpdf->Cell(30,30, mb_convert_encoding('Materia: '.$signature_name.', grupo:  ', "ISO-8859-1","UTF-8") );
            // $fpdf->Cell(30,30, 'Maestro: "'.$clave.'"' );
            $fpdf->Image('../assets/ITC-logo.png', 10, 6, 27);
            $fpdf->Ln(30);

        }
        function setFooter() {
            
        }

        function generateConsultanciesPDF($clave, $consultancieType) {
            $fpdf = new FPDF('L');
            $fpdf->AddPage('L'); //L = Landscape
            $this->setHeader($fpdf, $clave);
            $fpdf->SetFont('Arial','B',10);

            $table = $consultancieType;

            $select_query = 
            'SELECT
                concat(usu.nombres," ", usu.apellido_paterno," ", usu.apellido_materno," ") as alumno,
                ase.competencia,
                ase.tema,
                ase.descripcion,
                ase.fecha
            FROM '.$table.' AS ase
            JOIN usuario AS usu ON ase.id_usuario_toma = usu.id_usuario
            WHERE ase.clave = "'.$clave.'" ';

            $this->getRecord($select_query);
            if($this->registersNum > 0){

                // campos de la tabla
                // $campos=array();
                // $this->getFields($campos);

                $fpdf->Cell(70,12, 'Alumno' ,1);
                $fpdf->Cell(15,12, 'Comp.' ,1);
                $fpdf->Cell(70,12, 'Tema' ,1);
                $fpdf->Cell(100,12, mb_convert_encoding( 'Descripción', "ISO-8859-1","UTF-8") ,1);
                $fpdf->Cell(25,12, 'Fecha' ,1);
                // foreach($campos as $campo){
                //     $fpdf->Cell(46,12,$campo,1);
                // }
                $fpdf->Ln();
                
                // Pasar el valor de los campos
                foreach ($this->registrersBlock as $registerRow) {

                    $textWidth = $fpdf->GetStringWidth($registerRow["alumno"]);
                    if ($textWidth > 70) {
                        $textTruncated = $this->truncateText($fpdf, mb_convert_encoding( $registerRow["alumno"], "ISO-8859-1","UTF-8"), 70);
                        $fpdf->Cell(70,12,$textTruncated,1);
                    }else{
                        $fpdf->Cell(70,12,mb_convert_encoding( $registerRow["alumno"], "ISO-8859-1","UTF-8"),1);
                    }


                    $fpdf->Cell(15,12,$registerRow["competencia"],1);
                    $fpdf->Cell(70,12,mb_convert_encoding( $registerRow["tema"], "ISO-8859-1","UTF-8"),1);

                    $textWidth = $fpdf->GetStringWidth($registerRow["descripcion"]);
                    if ($textWidth > 100) {
                        $textTruncated = $this->truncateText($fpdf, $registerRow["descripcion"], 100);
                        $fpdf->Cell(100,12,mb_convert_encoding( $textTruncated, "ISO-8859-1","UTF-8"),1);
                    }else{
                        $fpdf->Cell(100,12,mb_convert_encoding( $registerRow["descripcion"], "ISO-8859-1","UTF-8"),1);
                    }

                    $fpdf->Cell(25,12,mb_convert_encoding( $registerRow["fecha"], "ISO-8859-1","UTF-8"),1);
                    $fpdf->Ln();
                }
            }
            $fpdf->Output();
        }

        // Función que recorta el contenido de un registro muy largo para ser mostrado.
        function truncateText($fpdf, $text, $maxWidth) {
            $ellipsis = "...";
            $ellipsisWidth = $fpdf->GetStringWidth($ellipsis);
            $truncatedText = "";
    
            for ($i = 0; $i < strlen($text); $i++) {
                $truncatedText .= $text[$i];
                if ($fpdf->GetStringWidth($truncatedText) + $ellipsisWidth > $maxWidth) {
                    return substr($truncatedText, 0, -1) . $ellipsis;
                }
            }
            // return $text;  // Return original text if no truncation is needed
        }

        function getSignatureName($signature_key) : string {
            $query_select = '
                select nombre 
                from materia ma
                left join grupo gr on ma.id_materia = gr.id_materia
                where gr.clave = "'.$signature_key.'"; 
            ';
            $signature = $this->getRecord($query_select);
            return $signature->nombre;
        }
    }

    $pdf = new PDFS();
    if(isset($_REQUEST['id'])){
        $pdf->generateConsultanciesPDF($_REQUEST['id'], $_REQUEST['table']);
    }
?>
