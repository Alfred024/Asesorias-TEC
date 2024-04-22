<?php
    // session_start();
    include "../classes/database.php";

    // Sería bueno hacer que en una misma clase se manden llamar las materias, asesorías, etc...
    class Signatures extends Database{

        function action($action_case) {
            switch ($action_case) {
                case 'displayData':
                    $user_id=$_SESSION['session_user_id'];
                    $query_param = 'select 
                        ma.id_materia,
                        ma.nombre,
                        ma.clave,
                        ma.grupo
                    from materia ma
                    left join asesoria ase on ma.id_materia = ase.id_materia
                    where ase.id_usuario_imparte = '.$user_id.'
                    group by ma.id_materia;';

                    $this->displayData($query_param);
                break;
            }
        }

        // AGREGAR BOTÓN PARA BORRAR UNA MATERIA
        // AGREGAR BOTÓN PARA EDITAR
        function displayData($query_param){
            $consultanciesContainerStart = '<div class="Subjects-Card-Container overflow-auto width-90">';
            $this->getRecord($query_param);

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

            $consultanciesContainerEnd = '</div>';
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