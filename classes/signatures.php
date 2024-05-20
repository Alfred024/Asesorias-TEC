<?php
    // session_start();
    // include "../classes/database.php";

    // Sería bueno hacer que en una misma clase se manden llamar las materias, asesorías, etc...
    class Signatures{

        private $databaseSignatures;

        public function __construct(Database $databaseSignatures) {
            $this->databaseSignatures = $databaseSignatures;
        }

        function action($action_case) {
            switch ($action_case) {
                case 'formEdit':
                //     $signature_info = $this->getRecord("select * from signature where id_usuario = " . $_REQUEST['id_user_to_update']);
                case 'formNew':
                    return 
                        '<div class="width-100 height-100 flex center-flex-xy">
                            <form onsubmit="return signatures(\'insert_signature\')" method="post" class="padding-20 box-shadow-dark flex-column justify-center bg-light-gray border-radius-30 relative" action="" style="width: 320px;">
                                <button onclick="return closeModal();" class="Btn-Primary-Blue absolute border-radius-full bg-primary-blue text-white border-none" style="width: 40px; height: 40px; top:0; right:0;">X</button>
                            
                                <h4 class="width-fit font-weight-600 margin-auto" >Registro de maestro</h4>
                                <hr style="margin: 10px;">
                    
                                <label class="flex-column width-100 margin-auto">
                                    Nombre de la materia
                                    <br>
                                    <input name="signature" class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
                                </label><br>
                    
                                <div class="flex justify-center">
                                    <label class="flex-column width-40 margin-auto">
                                        Clave de la materia
                                        <br>
                                        <input name="key" pattern="[A-Z]{2}\d{2}" class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
                                    </label>
                        
                                    <label class="flex-column width-40 margin-auto">
                                        Grupo
                                        <br>
                                        <input name="group" pattern="[A-Z]{1}" class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
                                    </label>
                                </div>
                                <br>

                                <input type="hidden" name="action" value="insert">
                                <input type="submit" class="Btn-Primary-Blue bg-primary-blue text-white border-radius-20 padding-10 border-none margin-auto" value="Registrar Materia" style="width: 200px;">
                            </form>
                        </div>';
                break;
                case 'insert_signature':
                    // Paso 1 : Crear la materia
                    $user_id=$_SESSION['session_user_id'];
                    $signature = $_REQUEST['signature'];
                    $group = $_REQUEST['group'];
                    $key = $_REQUEST['key'];

                    $insert_signature_query = "insert into materia (nombre) values ('".$signature."');";
                    $this->databaseSignatures->query($insert_signature_query);

                    $id_signature_inserted = $this->getId_signature($user_id, $signature);
                    $insert_signature_group_query = "insert into grupo (grupo, clave, id_usuario, id_materia) values ('".$group."', '".$key."', '".$user_id."', '".$id_signature_inserted."');";
                    $this->databaseSignatures->query($insert_signature_group_query);
                    // TODO: Notificación de creada correctamente
                    $this->action("displayData");
                break;
                case 'displayData':
                    $user_id=$_SESSION['session_user_id'];
                    $query_param = 'select
                        ma.id_materia,
                        ma.nombre,
                        gr.grupo,
                        gr.clave
                    from usuario usu
                    left join grupo gr on usu.id_usuario = gr.id_usuario
                    left join materia ma on gr.id_materia = ma.id_materia
                    where usu.id_usuario = '.$user_id.'
                    order by 1 asc;';

                    $this->displayData($query_param);
                break;
            }
        }

        // AGREGAR BOTÓN PARA BORRAR UNA MATERIA
        // AGREGAR BOTÓN PARA EDITAR
        function displayData($query_param){
            $consultanciesContainerStart = '<div class="Subjects-Card-Container flex overflow-auto width-90">';
            $this->databaseSignatures->getRecord($query_param);

            if($this->databaseSignatures->registersNum == 0){
                echo('<h5 class="color-primary-blue text-align-center font-size-15 padding-20 ">Aún no tienes materias registradas, pulsa el botón de + para agregar una nueva materia</h5>');
            }

            $subjectCards = '';
            foreach ($this->databaseSignatures->registrersBlock as $registerRow) {
                $subjectCards.='
                    <div>
                    <a onclick="return consultancies(\'select_signatures_consultancies\','.$registerRow['clave'].')" href="../teacher/consultancies.php" class="Subject-Card anchor-default margin-right-10 bg-primary-blue border-radius-30 text-white overflow-hidden">
                        <div class="flex-column justify-between padding-10" style="height: 80%;">
                            <p>Materia: '.$registerRow["nombre"].' </p>
                            <p class="font-size-15 text-light">GRUPO: '.$registerRow["grupo"].'</p>
                        </div>
                        <div class="bg-secondary-blue" style="height: 20%;">
                            <p class="text-align-end" style="padding-right: 20px;">Clave: '.$registerRow["clave"].'</p>
                        </div>
                    </a>
                    </div>
                ';
            }

            //Botón para agregar una materia
            $consultanciesContainerEnd = '</div>
                <button 
                    onclick="return signatures(\'formNew\')" 
                    class="Add-Subject-Button absolute border-radius-full" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-plus"></i>
                </button>';

            echo($consultanciesContainerStart.$subjectCards.$consultanciesContainerEnd);
        }
        
        function getId_signature($id_user, $signature_name) : int{
            $query_get_signature_id = "
            select ma.id_materia
                from materia ma
            where ma.nombre = '".$signature_name."'
            order by 1 desc
            limit 1;";

            $data = $this->databaseSignatures->getRecord($query_get_signature_id);
            return $data->id_materia;
        }
    }

    $databaseSignatures = new Database();
    $signaturesObject = new Signatures($databaseSignatures);
    if(isset($_REQUEST['action'])){
        echo $signaturesObject->action($_REQUEST['action']);
    }else{
        echo $signaturesObject->action('displayData');
    }
?>