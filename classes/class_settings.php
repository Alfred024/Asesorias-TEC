<?php 

    if (!isset($_SESSION)) session_start();
    if (!class_exists("Class_Database")) include "../classes/class_database.php"; 

    class Settings extends Class_Database{
        function action($action_case) {
            switch ($action_case) {
                case 'update_profile_picture':
                    
                    break;
                case 'update_pswd':

                break;
                case 'display_page':
                    $user_id = $_SESSION['session_user_id'];
                    $query_user_data = '
                        select 
                            us.id_usuario,
                            us.contrasena
                            -- us.foto
                        from usuario us 
                        where us.id_usuario = '.$user_id.'
                    ';
                    $this->display_page($query_user_data);
                break;
                default:
                    
                break;
            }
        }

        function display_page($query){
            $user = $this->getRecord($query); // Obtenemos datos del usuario
            echo('
                <div class="bg-white height-100 margin-auto padding-20 bg-white border-radius-10 box-shadow-light" style="max-width: 600px;">
                    <h2 class="color-primary-blue text-align-center margin-bottom-10">Configuración del Perfil</h2>

                    <!-- Editar Foto de Perfil -->
                    <div class="margin-bottom-10">
                        <div class="flex-column justify-center align-center gap-10">
                            <img class="profile-pic-img" src="default-profile.png" alt="Foto de Perfil" id="profile-pic">
                            <input class="display-none" type="file" id="upload-profile-pic" accept="image/*">
                            <button class="bg-primary-blue text-white border-none padding-10 border-radius-10 cursor-pointer" onclick="uploadProfilePic()">Subir Nueva Foto</button>
                        </div>
                    </div>

                    <!-- Cambiar Contraseña -->
                    <div class="margin-bottom-10">
                        <h3 class="margin-bottom-10 color-primary-blue">Cambiar Contraseña</h3>
                        <div class="flex-column justify-center">

                            <input class="input-1 margin-top-5" type="password" placeholder="Contraseña Actual">
                            <input class="input-1 margin-top-5" type="password" placeholder="Nueva Contraseña">
                            <input class="input-1 margin-top-5" type="password" placeholder="Confirmar Nueva Contraseña">

                            <button class="bg-primary-blue margin-auto margin-top-10 width-80 text-white border-none padding-10 border-radius-10 cursor-pointer">Confirmar</button>
                        </div>
                    </div>

                </div>
            ');
        }
    }

    $settingsObject = new Settings();

    if(isset($_REQUEST['action'])){
        $settingsObject->action($_REQUEST['action']);
    }else{
        $settingsObject->action($_REQUEST['display_page']);
    }
?>