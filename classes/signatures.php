<?php
    // session_start();
    include "../classes/database.php";

    // Sería bueno hacer que en una misma clase se manden llamar las materias, asesorías, etc...
    class Signatures extends Database{

        function action($action_case) {
            switch ($action_case) {
                case 'formNew':
                    // TODO: Preguntar al profe si esto lo puedo poner en otra parte
                    return 
                    '<div id="Modal-Container-Id" 
                        class="Modal-Container absolute z-index-10 relative height-full width-100 flex center-flex-xy" 
                        style="background-color: rgba(32,35,41,.8); top:0; bottom:0; left:0; right:0;">
                        <form class="padding-20 box-shadow-dark flex-column justify-center bg-light-gray border-radius-30 relative" action="" style="width: 320px;">
                            <button class="Btn-Primary-Blue absolute border-radius-full bg-primary-blue text-white border-none" style="width: 40px; height: 40px; top:0; right:0;">X</button>
                        
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
                                    <input name="key" class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
                                </label>
                    
                                <label class="flex-column width-40 margin-auto">
                                    Grupo
                                    <br>
                                    <input name="group" class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
                                </label>
                            </div>
                            <br>

                            <input type="hidden" name="action" value="insert">
                            <input type="submit" class="Btn-Primary-Blue bg-primary-blue text-white border-radius-20 padding-10 border-none margin-auto" value="Registrar Materia" style="width: 200px;">
                        </form>
                    </div>';
                break;
                case 'insert':
                    // VALIDAR QUE LOS DATOS SEAN INSERTS
                    $this->query("insert into materia (clave, nombre, grupo) values ('".$_REQUEST['key']."', '".$_REQUEST['signature']."', '".$_REQUEST['group']."')");
                    $this->action("displayData");
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
                    where us.id_usuario = '.$user_id.';';

                    $this->displayData($query_param);
                break;
            }
        }

        // AGREGAR BOTÓN PARA BORRAR UNA MATERIA
        // AGREGAR BOTÓN PARA EDITAR
        function displayData($query_param){
            $consultanciesContainerStart = '<div class="Subjects-Card-Container overflow-auto width-90">';
            $this->getRecord($query_param);

            if($this->registersNum == 0){
                echo('<h5 class="color-primary-blue text-align-center font-size-15 padding-20 ">Aún no tienes materias registradas, pulsa el botón de + para agregar una nueva materia</h5>');
            }

            $subjectCards = '';
            foreach ($this->registrersBlock as $registerRow) {
                $subjectCards.='
                <!-- TODO: Agregar la acción para que haga un select de las asesorias de esa materia -->
                <a href="../teacher/consultancies.php" class="Subject-Card anchor-default margin-right-10 bg-primary-blue border-radius-30 text-white overflow-hidden">
                    <div class="flex-column justify-between padding-10" style="height: 80%;">
                        <p>Materia: '.$registerRow["nombre"].' </p>
                        <p class="font-size-15 text-light">GRUPO: '.$registerRow["grupo"].'</p>
                    </div>
                    <div class="bg-secondary-blue" style="height: 20%;">
                        <p class="text-align-end" style="padding-right: 20px;">Clave: '.$registerRow["clave"].'</p>
                    </div>
                </a>';
            }

            $consultanciesContainerEnd = '</div>
            <form method="post">
                <button type="submit" class="Add-Subject-Button absolute border-radius-full" style="width: 50px; height: 50px;">
                    <i class="fa-solid fa-plus"></i>
                </button>
                <input type="hidden" name="action" value="formNew">
            </form>';

            echo($consultanciesContainerStart.$subjectCards.$consultanciesContainerEnd);
        }
        
    }

    $signaturesObject = new Signatures();
    if(isset($_REQUEST['action'])){
        echo $signaturesObject->action($_REQUEST['action']);
    }else{
        echo $signaturesObject->action('displayData');
    }
?>