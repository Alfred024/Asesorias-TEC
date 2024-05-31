<?php
    // session_start();
    if (!class_exists("PDFS")) include "../classes/pdfs.php";
    if (!class_exists("Class_Database")) include "../classes/class_database.php";

    class Consultancies extends Class_Database{

        // private $pdf;
    
        // public function __construct()
        // {
        //     $this->pdf = new PDFS;
        // }

        function action($action_case) {
            switch ($action_case) {
                case 'formNew':
                    // Obtener la clave del request
                    // Obtener el id_usuario del maestro de la sesión
                    $clave = strval($_REQUEST['clave']);
                    $students = $this->displayStudents();
                    return 
                        '<div class="width-100 flex center-flex-xy" style="height: 90vh;">
                        <form 
                            onsubmit="return consultancies(\'insert_consultancie\')" method="post"
                            class="padding-20 box-shadow-dark flex-column justify-center bg-light-gray border-radius-30 relative" action="" style="width: 320px;">
                            <button class="Btn-Primary-Blue absolute border-radius-full bg-primary-blue text-white border-none" style="width: 40px; height: 40px; top:0; right:0;">X</button>
                
                            <h4 class="width-fit font-weight-600 margin-auto">Registro de asesoría</h4>
                            <hr style="margin: 10px;">
                
                            <input class="width-100 margin-auto box-shadow-light border-radius-20 padding-5 border-none" type="text" name="tema" placeholder="Tema de la asesoría">
                            <br>
                
                            <div class="flex gap-10">
                                <label class="flex-column margin-auto">
                                    Competencia
                                    <br>
                                    <select class="box-shadow-light border-radius-20 padding-5 border-none" name="competencia">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                    </select>
                                </label>
                
                                <label class="flex-column margin-auto">
                                    Periodo
                                    <br>
                                    <select class="box-shadow-light border-radius-20 padding-5 border-none" name="id_periodo">
                                        <option value="1">Enero-Junio</option>
                                        <option value="2">Agosto-Diciembre</option>
                                    </select>
                                </label>
                            </div>
                            <br>
                
                            <textarea style="height: 100px; resize: none;" class="width-100 margin-auto box-shadow-light border-radius-20 padding-5 border-none" name="descripcion" placeholder="Descripción de la asesoría"></textarea>
                            <br>
                
                            <label class="flex-column width-100 margin-auto">
                                Alumno toma la asesoría
                                <br>
                                <select class="box-shadow-light border-radius-20 padding-5 border-none" name="alumno">
                                    '.$students.'
                                </select>
                            </label><br>

                            <input type="hidden" name="clave" value="'.$clave.'"></input>
                            <input type="hidden" name="action" value="insert_consultancie"></input>
                            <input type="submit" class="Btn-Primary-Blue bg-primary-blue text-white border-radius-20 padding-10 border-none margin-auto" value="Registrar Asesoría" style="width: 200px;">
                        </form>
                        </div>';
                
                break;
                case 'insert_consultancie':
                    $tema = $_REQUEST['tema'];
                    $description = $_REQUEST['descripcion'];
                    $competencia = $_REQUEST['competencia'];
                    $user_id=$_SESSION['session_user_id'];
                    $user_id_toma=$_REQUEST['alumno'];
                    $signature_key=$_REQUEST['clave'];
                    $signature_period=$_REQUEST['id_periodo'];

                    $insert_consultancie_query = '
                    insert into asesoria
                    (tema, competencia, descripcion, id_usuario_imparte, id_usuario_toma, clave, id_periodo)
                    values ("'.$tema.'", "'.$competencia.'", "'.$description.'", "'.$user_id.'", "'.$user_id_toma.'", "'.$signature_key.'", "'.$signature_period.'");
                    ';

                    $this->query($insert_consultancie_query);
                    // TODO: Notificación de creada correctamente
                    // echo('<h1>Asesoría registrada bienn</h1>');
                    $this->action("displayData_signature");
                break;
                case 'displayData_signature':
                    // $user_id=$_SESSION['session_user_id'];
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
            }
        }

        function displayData($query_param){
            $this->getRecord($query_param);

            if($this->registersNum == 0){
                // echo('
                // <div class="flex-column justify-center margin-bottom-10 color-primary-blue">
                //     <h5 class="padding-20 text-align-center font-size-15">Aún no tienes asesorías registradas de esta materia</h5>
                //     <i class="fa-solid fa-box-archive fa-xl margin-auto"></i>
                // </div>');
                echo('<p>NO HAY ASESORÍAS REGISTRADAS</p>');
            }

            $tableStart='
            <table class="Assesories-Table overflow-x-auto padding-10 width-90 margin-auto" style="background-color: white;">
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
                    <td style="max-width: 100px;">'.$registerRow["descripcion"].'</td>
                    <td>'.$registerRow["fecha"].'</td>
                </tr>';
            }
            $tableEnd='
                </tbody>
            </table>';

            echo($tableStart.$consultancies.$tableEnd);
        }

        function displayStudents(){
            $this->getRecord('
            select
                us.id_usuario,
                concat(us.nombres, " ",us.apellido_paterno, " ",us.apellido_materno) as alumno
            from usuario us
            where us.id_rol = 3;');
    
            $students='';
            foreach ($this->registrersBlock as $registerRow) {
                $students.='
                <option value="'.$registerRow['id_usuario'].'">'.$registerRow['alumno'].'</option>';
            }
            return $students;
        }

        function getUserIdByCtrlNum($user_ctrl_num) : int {

            return 0;
        }
    }


    // $databaseConsultancies = new Class_Database();
    // $consultanciesObject = new Consultancies($databaseConsultancies);
    $consultanciesObject = new Consultancies();
    if(isset($_REQUEST['action'])){
        echo $consultanciesObject->action($_REQUEST['action']);
    }else{
        $current_page = $_SERVER['SCRIPT_NAME'];
        // echo $current_page;

        switch ($current_page) {
            case '/asesorias/teacher/home.php':
                echo $consultanciesObject->action('displayData_recent');
                break;
            case '/asesorias/teacher/consultancies.php':
                echo $consultanciesObject->action('displayData_signature');
                break;
            default:
                # code...
                break;
        }
    }
?>
