<?php
    // session_start();
    include "../classes/database.php";

    // PREGUNTAR AL PROFE: Sería bueno hacer que en una misma clase se manden llamar las materias, asesorías, etc...??
    class Consultancies extends Database{

        function action($action_case) {
            switch ($action_case) {
                case 'displayData_recent':
                    $user_id=$_SESSION['session_user_id'];

                    $query_param = 
                    'SELECT
                        concat(usu.nombres," ", usu.apellido_paterno," ", usu.apellido_materno," ") as alumno,
                        ase.competencia,
                        ase.tema,
                        ase.descripcion,
                        ase.fecha
                    FROM asesoria AS ase
                    JOIN usuario AS usu ON ase.id_usuario_toma = usu.id_usuario
                    where ase.id_usuario_imparte = '.$user_id.'
                    order by 5 desc
                    limit 8;'; 
                    $this->displayData($query_param);
                break;

                case 'displayData_signature':
                    $user_id=$_SESSION['session_user_id'];

                    // CÓMO OBTENGO LA "clave"??
                    $signature_key=$_POST['clave'];
                    echo($signature_key);
                    // $query_param = 
                    // 'SELECT
                    //     concat(usu.nombres," ", usu.apellido_paterno," ", usu.apellido_materno," ") as alumno,
                    //     ase.competencia,
                    //     ase.tema,
                    //     ase.descripcion,
                    //     ase.fecha
                    // FROM asesoria AS ase
                    // JOIN usuario AS usu ON ase.id_usuario_toma = usu.id_usuario
                    // WHERE ase.clave = "CA01A"';
                    // // De dónde saco la clave de la materia? Encierro mi elemento de materia en un form que contenga un post y luego las pido de la REQUEST? o hay una forma más bonita de hacerlo?
                    //     $this->displayData($query_param);
                break;
            }
        }

        function displayData($query_param){
            $this->getRecord($query_param);

            if($this->registersNum == 0){
                echo('
                <div class="flex-column justify-center margin-bottom-10 color-primary-blue">
                    <h5 class="padding-20 text-align-center font-size-15">Aún no tienes asesorías registradas de esta materia</h5>
                    <i class="fa-solid fa-box-archive fa-xl margin-auto"></i>
                </div>');
            }

            $tableStart='
            <table class="Assesories-Table overflow-x-auto padding-10 width-100" style="background-color: white;">
                <thead class="Table-Header">
                    <tr class="text-secondary-blue">
                        <th>Alumno</th>
                        <th>Competencia</th>
                        <th>Tema</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>';
            
            $consultancies = '';
            foreach ($this->registrersBlock as $registerRow) {
                $consultancies.='
                <tr>
                    <td>'.$registerRow["alumno"].'</td>
                    <td>'.$registerRow["competencia"].'</td>
                    <td>'.$registerRow["tema"].'</td>
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
        $current_page = $_SERVER['SCRIPT_NAME'];
        // echo $current_page;

        switch ($current_page) {
            case '/asesorias-app/teacher/control_panel.php':
                echo $consultanciesObject->action('displayData_recent');
                break;
            case '/asesorias-app/teacher/consultancies.php':
                echo $consultanciesObject->action('displayData_signature');
                break;
            default:
                # code...
                break;
        }
    }
?>