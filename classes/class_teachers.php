<?php
    if (!isset($_SESSION)) session_start();
    if (!class_exists("PDFS")) include "../classes/class_pdfs.php";
    if (!class_exists("Class_Database")) include "../classes/class_database.php";

    class Teachers extends Class_Database{

        function action($action_case) {
            switch ($action_case) {
                case 'displayData':
                    $query_param = 
                    "select
                        concat(us.nombres, ' ',us.apellido_paterno, ' ',us.apellido_materno) as maestro,
                        us.id_usuario as id_maestro
                    from usuario us where id_rol = 1;"; // ID ROL DE UN MAESTRO
                    $this->displayData($query_param);
                break;
                case 'searchTeacher':
                    if(isset($_REQUEST['teacherSearched'])){
                        $teacherSearched = $_REQUEST['teacherSearched'];
                    }

                    $searchTeacher_query =
                    'SELECT
                        concat(us.nombres, " ",us.apellido_paterno, " ",us.apellido_materno) AS maestro,
                        us.id_usuario AS id_maestro
                    FROM usuario us WHERE id_rol = 1 AND
                    CONCAT (us.nombres, " ", us.apellido_paterno, " ", us.apellido_materno, " ") 
                    LIKE CONCAT("%'.$teacherSearched.'%");';
                    $this->displayData($searchTeacher_query);
                break;
            }
        }

        function displayData($query_param){
            $this->getRecord($query_param);

            if($this->registersNum == 0){
                echo('<p>AÚN NO HAY MAESTROS REGISTRADOS</p>');
                return;
            }

            $signatures = '';
            $teachersHtml = '<div id="Teachers_Container" style="padding: 20px;">';

            $id_list = 1;
            foreach ($this->registrersBlock as $registerRow) {
                $id_maestro = intval($registerRow["id_maestro"]);
                $signatures = $this->displayTeacherSignature($id_maestro, $id_list);

                $teachersHtml.='
                <div id="Teacher_Asseroires_Resume" class="Teacher-Assesories-Resume width-100 margin-bottom-10">
    
                    <div class="bg-white flex justify-between align-center padding-10 border-radius-10">
                        <div class="flex align-center">
                            <img class="margin-right-10" src="https://www.svgrepo.com/show/295402/user-profile.svg" alt="User profile picture" style="width: 35px;">
                            <p>'.$registerRow["maestro"].'</p>
                        </div>
            
                        <button style="cursor: pointer;" onclick="return toggleAssesoriesMenu(\''.$id_list.'\')" class="bg-bolor-unset border-none">
                            <i id="assesoriesMenuButton_Down_'.$id_list.'" class="fa-solid fa-chevron-down color-primary-blue"></i>
                            <i id="assesoriesMenuButton_Up_'.$id_list++.'" class="fa-solid fa-chevron-up color-primary-blue" style="display: none;"></i>
                        </button>
                    </div>
    
                    <!-- AQUÍ IRÁN LAS MATERIAS DE LOS MAESTROS --> 
                    '.$signatures.'
                </div>';
            }
            
            echo($teachersHtml.'</div>');
        }

        function displayTeacherSignature($id_teacher, $id_list){
            $this->getRecord("
            select
                ma.nombre as materia,
                gr.clave as clave
            from materia ma
            left join grupo gr on ma.id_materia = gr.id_materia
            left join usuario us on gr.id_usuario = us.id_usuario
            where us.id_usuario = $id_teacher;");

            $signatures = '';
            if($this->registersNum !== 0){
                $signatures='<div id="Assesories_List_'.$id_list.'" class="anchor-default bg-white border-radius-10 margin-y-5 padding-10" style="display: block;">';

                foreach ($this->registrersBlock as $registerRow) {
                    $signatures.='
                    <div
                    onclick="return consultancies(\'select_signatures_consultancies\',\''.$registerRow['clave'].'\')" class="width-80 margin-auto margin-bottom-10 flex justify-between padding-10 bg-primary-blue text-white border-radius-10">
                        <p>Reporte de asesorías de '.$registerRow['materia'].'</p>
                        <button onclick="return consultancies(\'select_signatures_consultancies\', \''.$registerRow['clave'].'\');" class="bg-bolor-unset border-none">
                            <i class="fa-solid fa-chevron-right" style="color: white;"></i>
                        </button>
                    </div>
                    ';
                }
                $signatures.='</div>';
            }
    
            return $signatures;
        }

        function getUserIdByCtrlNum($user_ctrl_num) : int {

            return 0;
        }
    }


    // $databaseConsultancies = new Class_Database();
    // $consultanciesObject = new Teachers($databaseConsultancies);
    $consultanciesObject = new Teachers();
    if(isset($_REQUEST['action'])){
        echo $consultanciesObject->action($_REQUEST['action']);
    }else{
        echo $consultanciesObject->action('displayData');
    }
?>
