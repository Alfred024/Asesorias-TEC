<?php
    // session_start();
    include "../classes/database.php";

    // Sería bueno hacer que en una misma clase se manden llamar las materias, asesorías, etc...
    class Consultancies extends Database{

        function action($action_case) {
            switch ($action_case) {
                case 'displayData':
                $query_param = 
                    'select
                        ma.nombre as materia,
                        concat(us.nombres," ",us.apellido_paterno," ",us.apellido_materno) as alumno,
                        ase.competencia,
                        ase.descripcion,
                        ase.fecha
                    from asesoria ase
                    left join materia ma on ase.id_materia = ma.id_materia
                    left join usuario us on ase.id_usuario_toma = us.id_usuario
                    where ma.clave = "FGHIJ";'; // De dónde saco la clave de la materia? Encierro mi elemento de materia en un form que contenga un post y luego las pido de la REQUEST? o hay una forma más bonita de hacerlo?
                    $this->displayData($query_param);
                break;
            }
        }

        function displayData($query_param){
            $this->getRecord($query_param);

            if($this->registersNum == 0){
                echo('
                <div class="flex-column justify-center margin-bottom-10 color-primary-blue">
                    <h5 class="padding-20 text-align-center font-size-15">Aún no tienes asesorías registradas</h5>
                    <i class="fa-solid fa-box-archive fa-xl margin-auto"></i>
                </div>');
            }

            $tableStart='
            <table class="Assesories-Table overflow-x-auto padding-10 width-100" style="background-color: white;">
                <thead class="Table-Header">
                    <tr class="text-secondary-blue">
                        <th>Materia</th>
                        <th>Grupo</th>
                        <th>Alumno</th>
                        <th>Competencia</th>
                        <th>Tema</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>';
            
            $consultancies = '';
            foreach ($this->registrersBlock as $registerRow) {
                $consultancies.='
                <tr>
                    <td>'.$registerRow["materia"].'</td>
                    <td>'.$registerRow["alumno"].'</td>
                    <td>'.$registerRow["competencia"].'</td>
                    <td>'.$registerRow["descripcion"].'</td>
                    <td>'.$registerRow["fecha"].'</td>
                </tr>';
            }
            $tableEnd='
                </tbody>
            </table>';

            echo($tableStart.$consultancies.$tableEnd);
        }
        
    }

    $consultanciesObject = new Consultancies();
    if(isset($_REQUEST['action'])){
        echo $consultanciesObject->action($_REQUEST['action']);
    }else{
        echo $consultanciesObject->action('displayData');
    }
?>