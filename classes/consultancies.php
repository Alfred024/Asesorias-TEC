<?php
    // session_start();
    // include "../classes/database.php";

    class Consultancies{

        private $databaseConsultancies;

        public function __construct(Database $databaseConsultancies) {
            $this->databaseConsultancies = $databaseConsultancies;
        }

        function action($action_case) {
            switch ($action_case) {
                case 'insert':
                    $tema = $_POST['tema'];
                    $description = $_POST['descripcion'];
                    $competencia = $_POST['competencias'];
                    $user_id=$_SESSION['session_user_id'];
                    $user_id_toma= $this->getUserIdByCtrlNum('21030001'); // TODO: Obtener el campo usuario de 
                    $signature_key=$_POST['clave'];
                    $signature_period=$_POST['periodo'];

                    $insert_signature_query = '
                    insert into asesoria
                    ("tema", competencia, descripcion, hora, fecha, id_usuario_imparte, id_usuario_toma, clave, id_periodo)
                    values ("'.$tema.'", "'.$competencia.'", "'.$description.'", curtime(), curdate(), "'.$user_id.'", "'.$user_id_toma.'", "'.$signature_key.'", "'.$signature_period.'");
                    ';
                break;
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
                    $signature_key=$_REQUEST['clave'];
                    // echo($signature_key);
                    $query_param = 
                    'SELECT
                        concat(usu.nombres," ", usu.apellido_paterno," ", usu.apellido_materno," ") as alumno,
                        ase.competencia,
                        ase.tema,
                        ase.descripcion,
                        ase.fecha
                    FROM asesoria AS ase
                    JOIN usuario AS usu ON ase.id_usuario_toma = usu.id_usuario
                    WHERE ase.clave = "'.$signature_key.'" ';
                    $this->displayData($query_param);
                break;
            }
        }

        function displayData($query_param){
            $this->databaseConsultancies->getRecord($query_param);

            if($this->databaseConsultancies->registersNum == 0){
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
            foreach ($this->databaseConsultancies->registrersBlock as $registerRow) {
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

        function getUserIdByCtrlNum($user_ctrl_num) : int {

            return 0;
        }
        
    }

    $databaseConsultancies = new Database();
    $consultanciesObject = new Consultancies($databaseConsultancies);
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
