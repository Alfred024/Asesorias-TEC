<?php 
    include './database.php';
    session_start();

    class Access extends Database{
        function action($action_case){
            switch ($action_case) {
                case 'login':
                    $this->login();
                    break;
                case 'register':
                    $this->register();
                    break;
                case 'passwordRecover':
                    # code...
                    break;
            }            
        }

        function login(){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $captcha = $_POST['captcha'];

            // TODO: Método comprobar que los campos no estén vaciós
            if($email != null && $password != null && $captcha != null){
                if($this->emailRegistered($email)){
                    $querySelectUser = "select * from usuario where email='{$email}' and contrasena='{$password}'";
                    $user = $this->getRecord($querySelectUser);
                    
                    if($this->registersNum == 1){
                        $_SESSION['session_email'] = $user->email;
                        $_SESSION['session_password'] = $user->contrasena;
                        $_SESSION['session_username'] = $user->nombres;
                        //echo($user->id_rol);
                        
                        // TODO: Arreglar B.D. y evaluar el tipo de usuario
                        // ES MAESTRO
                        if($user->id_rol == 1){ 
                            $_SESSION['admin'] = FALSE;
                            header("location: ../teacher/control_panel.php");
                        }
                        // ES ADMIN
                        else{ 
                            $_SESSION['admin'] = TRUE;
                            header("location: ../admin/control_panel.php");
                        }
                    }else{
                        header("location: ../login.php?m=3"); // Datos inválidos, pruebe a escribir los datos de nuevo
                    }
                }else{
                    header("location: ../login.php?m=2"); // El usuario no está registrado
                }
            }else{
                header("location: ../login.php?m=1");  // Llenar todos los campos
            }
        }

        function register(){
            $names = $_POST['names'];
            $last_name = $_POST['last_name'];
            $second_last_name= $_POST['second_last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password2 = $_POST['password2'];
            $captcha = $_POST['captcha'];

            // TODO: Método comprobar que los campos no estén vaciós
            if($names != null && $last_name != null && $second_last_name != null && $email != null && $password != null && $password2 != null && $captcha != null){
                if( $password !=  $password2){
                    header("location: ../register.php?m=5"); // Las contraseñas no coinciden
                }

                if($this->emailRegistered($email)){
                    header("location: ../register.php?m=2"); // El usuario ya está registrado
                }else{
                    $queryInsertUser = "insert into usuario (id_rol, email, nombres, apellido_paterno, apellido_materno, contrasena)
                    values (1, '{$email}', '{$names}', '{$last_name}', '{$second_last_name}', '{$password}');";
                    $this->query($queryInsertUser);

                    header('location: ../register.php?m=4');
                    
                    // Comprobar si se pudo mandar el correo
                    header("location: ../register.php?m=3"); // El registro no puedo realizarse con éxito
                }
            }else{
                header("location: ../register.php?m=1");  // Llenar todos los campos
            }
        }

        function passwordRecover(){
            
        }

        function emailRegistered($email) : bool {
            $querySelectUser = "select * from usuario where email='{$email}'";
            $this->getRecord($querySelectUser);
            if($this->registersNum == 1){
                return TRUE;
            }
            return FALSE;
        }

    }

    $access = new Access();
    if(isset($_REQUEST['action'])){
        echo $access->action($_REQUEST['action']);
    }
?>