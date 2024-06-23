<?php
    // session_start();
    // include './consultancies.php'; # INCLUDE PARA 
    if (!isset($_SESSION)) session_start();
    if (!class_exists("Class_Database")) include "../classes/class_database.php"; 

    // Sería bueno hacer que en una misma clase se manden llamar las materias, asesorías, etc...
    class Signatures extends Class_Database{

        function action($action_case) {
            switch ($action_case) {
                // case 'formEdit':
                //     $signature_info = $this->getRecord("select * from materia where clave = " . $_REQUEST['clave_to_update']);
                case 'formEdit':
                    $signature_info = $this->getRecord("select * from grupo where clave = '".$_REQUEST['clave']."'");
                case 'formNew':
                    $signatures = $this->displaySignatures();
                    $controller_method = !isset($signature_info) ? 'insert_signature' : 'update_signature';
                    return 
                        '<form 
                            id="form_signature"
                            onsubmit="return signatures(\''.$controller_method.'\')" method="post" class="flex-column justify-center relative" action="" style="width: 320px;">
                                
                                '. (!isset($signature_info) ? '
                                    <label class="flex-column width-100 margin-auto">
                                        Materia
                                        <br>
                                        <select
                                            id="signatureId" name="signature"
                                            class="box-shadow-light border-radius-20 padding-5 border-none">
                                            ' . $signatures . '
                                        </select>
                                    </label><br>
                                ' : '' ).'
                    
                                <div class="flex justify-between">
                                    <label class="flex-column width-60">
                                        Clave de la materia
                                        <br>
                                        <input 
                                            value="'.(isset($signature_info) ? $signature_info->clave : '' ).'"
                                            id="keyId" 
                                            name="key" pattern="[A-Z]{2}\d{2}" class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">

                                        '.(isset($signature_info) ? '<input type="hidden" name="current_key" value="'.$signature_info->clave.'" >' : '').'
                                    </label>
                        
                                    <label class="flex-column width-20">
                                        Grupo
                                        <br>
                                        <input 
                                            value="'.(isset($signature_info) ? $signature_info->grupo : '' ).'"
                                            id="groupId"
                                            name="group" pattern="[A-Z]{1}" class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
                                    </label>
                                </div>
                                <br>

                                '. (!isset($signature_info) ? '
                                    <label class="flex-column width-100 margin-auto">
                                        Periodo
                                        <br>
                                        <select class="box-shadow-light border-radius-20 padding-5 border-none" name="id_periodo">
                                            <option value="1">Enero-Junio</option>
                                            <option value="2">Agosto-Diciembre</option>
                                        </select>
                                    </label>
                                ' : '' ).'
                                <br>

                                <input type="hidden" name="action" 
                                    value="'.(isset($signature_info) ? 'update_signature' : 'insert_signature' ).'">
                                
                                <input type="submit" class="Btn-Primary-Blue bg-primary-blue text-white border-radius-20 padding-10 border-none margin-auto" 
                                value="'.(isset($signature_info) ? 'Actualizar materia' : 'Registrar materia' ).'"
                                style="width: 200px;">
                                <span id="message"></span>
                            </form>';
                break;
                case 'insert_signature':
                    $user_id = $_SESSION['session_user_id'];
                    $signature = $_REQUEST['signature'];
                    $group = $_REQUEST['group'];
                    $key = $_REQUEST['key'];
                    $signature_period = $_REQUEST['id_periodo'];
                
                    $id_signature_inserted = $this->getId_signature($signature);
                    $insert_signature_group_query = "INSERT INTO grupo (grupo, clave, id_usuario, id_materia, id_periodo) VALUES ('$group', '$key', '$user_id', '$id_signature_inserted', '$signature_period');";
                    $this->query($insert_signature_group_query);
                
                    $this->action('displayData');
                break;
                case 'update_signature':
                    $this->query("
                    update grupo set 
                        clave ='".$_REQUEST['key']."', 
                        grupo='".$_REQUEST['group']."'
                    where clave='".$_REQUEST['current_key']."'
                    ");
                    $this->action('displayData');
                break;
                case 'delete':
                    // echo($_REQUEST['signature_Id']);
                    $delete_query = 'delete from materia where id_materia = '.$_REQUEST['signature_Id'].'';    
                    $this->query($delete_query);
                    $this->action('displayData');
                break;
                case 'displayData':
                    $user_id=$_SESSION['session_user_id'];
                    $query_param = 'select
                        ma.id_materia,
                        ma.nombre,
                        gr.grupo,
                        gr.clave
                    from materia ma
                    left join grupo gr on ma.id_materia = gr.id_materia
                    left join usuario us on gr.id_usuario = us.id_usuario
                    where us.id_usuario = '.$user_id.'
                    order by 1 asc;';

                    $this->displayData($query_param);
                break;
                case 'display_page':
                    $query_param = '
                    select
                        ma.id_materia,
                        ma.nombre,
                        gr.grupo,
                        gr.clave, 
                        gr.año,
                        us.id_usuario
                    from grupo_archivado gr 
                    left join materia ma on ma.id_materia = gr.id_materia
                    left join usuario us on gr.id_usuario = us.id_usuario; -- Dato necesario si queremos concoer quién la impartió';
                break;
            }
        }

        // AGREGAR BOTÓN PARA EDITAR
        function displayData($query_param){
            $consultanciesContainerStart = '<div id="SubjectsCardsContainerId" class="Subjects-Card-Container flex overflow-auto width-90">';
            $this->getRecord($query_param);

            if($this->registersNum == 0){
                echo('<h5 class="color-primary-blue text-align-center font-size-15 padding-20 ">Aún no tienes materias registradas, pulsa el botón de (+) para agregar una nueva materia</h5>');
            }
            $subjectCards = '';
            foreach ($this->registrersBlock as $registerRow) {
                // Cómo podemos hacer para aplicar la misma lógica de enviar un valor con input submit + hidden para que obtega la clave y usar el href
                $subjectCards.='
                    <div>
                    <div 
                        onclick="return consultancies(\'select_signatures_consultancies\',\''.$registerRow['clave'].'\')" 
                        class="Subject-Card anchor-default margin-right-10 bg-primary-blue border-radius-30 text-white overflow-hidden">
                        <div class="flex-column justify-between padding-10" style="height: 80%;">
                            <p>Materia: '.$registerRow["nombre"].' </p>
                            <div class="flex justify-between">
                                <p class="font-size-15 text-light">GRUPO: '.$registerRow["grupo"].'</p>
                                <div class="flex">
                                    <button 
                                        onclick="event.stopPropagation(); return signatures(\'delete\', \''.$registerRow['id_materia'].'\');"
                                        class="margin-right-10 text-white bg-bolor-unset border-none">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                    <button 
                                        onclick="event.stopPropagation(); return signatures(\'formEdit\', \''.$registerRow['clave'].'\');"
                                        class="margin-right-10 text-white bg-bolor-unset border-none">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>
                            </div>
                
                        </div>
                        <div class="bg-secondary-blue" style="height: 20%;">
                            <p class="text-align-end" style="padding-right: 20px;">Clave: '.$registerRow["clave"].'</p>
                        </div>
                    </div>
                    </div>
                ';
            }

            //Botón para agregar una materia
            $consultanciesContainerEnd = '</div>
                <button 
                    onclick="return signatures(\'formNew\');" 
                    class="Add-Subject-Button absolute border-radius-full" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-plus"></i>
                </button>';

            echo($consultanciesContainerStart.$subjectCards.$consultanciesContainerEnd);
        }

        function displaySignatures(){
            $this->getRecord('select * from materia order by nombre;');

            $signatures = '';
            foreach ($this->registrersBlock as $registerRow) {
                $signatures .= '
                    <option value="' .$registerRow['nombre'] . '">' . $registerRow['nombre'] . '</option>';
            }
            return $signatures;
        }
        
        function getId_signature($signature_name) : int{
            $query_get_signature_id = "
            select ma.id_materia
                from materia ma
            where ma.nombre = '".$signature_name."'
            order by 1 desc
            limit 1;";

            $data = $this->getRecord($query_get_signature_id);
            return $data->id_materia;
        }
    }

    $signaturesObject = new Signatures();
    if(isset($_REQUEST['action'])){
        echo $signaturesObject->action($_REQUEST['action']);
    }else{
        echo $signaturesObject->action('displayData');
    }

?>