<?php

if (!isset($_SESSION)) session_start();
if (!class_exists("Class_Database")) include "../classes/class_database.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../resources/mailer/src/SMTP.php';
require '../resources/mailer/src/PHPMailer.php';
require '../resources/mailer/src/Exception.php';

// include './class_database.php';

class Class_Access extends Class_Database
{
    function action($action_case)
    {
        switch ($action_case) {
            case 'login':
                $this->login();
                break;
            case 'register':
                $this->register();
                break;
            case 'validateAccount':
                $this->validateAccount();
                break;
            case 'passwordRecover':
                $this->passwordRecover();
                break;
            case 'updateNewPassword':
                $this->updateNewPassword();
                break;
            case 'sendEmail':
                $email_html = $_REQUEST['email_html'];
                $email_destination = $_REQUEST['email'];
                $email_subject = $_REQUEST['email_subject'];
                $this->sendEmail($email_html, $email_destination, $email_subject);
                break;
        }
    }

    function login(){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];

        if ($email != null && $password != null && $captcha != null) {
            if ($this->emailRegistered($email)) {
                $querySelectUser = "select * from usuario where email='{$email}'";
                $user = $this->getRecord($querySelectUser);
    
                // if ($this->registersNum == 1 && password_verify($password, $user->contrasena)) {
                if ($this->registersNum == 1) {
                    if(isset($user->token_activacion)){
                        header("location: ../index.php?m=6"); // Checa tu email para verificar tu cuenta antes de ingresar
                    }else{
                        $_SESSION['session_user_id'] = $user->id_usuario;
                        $_SESSION['session_email'] = $user->email;
                        $_SESSION['session_password'] = $user->contrasena;
                        $_SESSION['session_username'] = $user->nombres;
    
                        // TODO: Arreglar B.D. y evaluar el tipo de usuario
                        // ES MAESTRO
                        if ($user->id_rol == 1) {
                            $_SESSION['admin'] = FALSE;
                            header("location: ../teacher/home.php");
                        }
                        // ES ADMIN
                        else {
                            $_SESSION['admin'] = TRUE;
                            header("location: ../admin/home.php");
                        }
                    }
                } else {
                    header("location: ../index.php?m=3"); // Datos inválidos, pruebe a escribir los datos de nuevo
                }
            } else {
                header("location: ../index.php?m=2"); // El usuario no está registrado
            }
        } else {
            header("location: ../index.php?m=1");  // Llenar todos los campos
        }
    }

    function register(){
        $names = $_POST['names'];
        $last_name = $_POST['last_name'];
        $second_last_name = $_POST['second_last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $captcha = $_POST['captcha'];

        // TODO: Método comprobar que los campos no estén vaciós
        if ($names != null && $last_name != null && $second_last_name != null && $email != null && $password != null && $password2 != null && $captcha != null) {
            if ($password !=  $password2) {
                header("location: ../register.php?m=5"); // Las contraseñas no coinciden
            }

            if ($this->emailRegistered($email)) {
                header("location: ../register.php?m=2"); // El usuario ya está registrado
            } else {
                ob_start();

                // Se crea el hash de activación
                $activation_token = bin2hex(random_bytes(16));
                $activation_token_hash = hash("sha256", $activation_token);

                $emailHTML = 
                    '<article
                        style="background-color: #f0efef; margin: 10px; display: flex; flex-direction:column; justify-content: center; padding: 20px; border-block: solid 4px #1B396A; ">

                        <h4 style="text-align:center;">Bienvenido al Sistema de Asesorías del Departamento de Ingeniería Industrial</h4><br>

                        <p style="text-align:center;">Para confirmar la creación del usuario, por favor oprima el botón.</p><br>

                        <a href="https://tigger.celaya.tecnm.mx/AsesoriasInd/classes/class_access.php?action=validateAccount&token='.$activation_token.'" style="width: 200px; padding: 10px; border-radius: 10px; margin:auto; background-color: #1B396A; color: white; border:none; cursor:pointer;">Confirmar</a>
                    </article>';
                
                

                if (!$this->sendEmail($emailHTML, $email, "Confirmacion de creacion de cuenta")) {
                    // echo  "Error sending the email: " . $mail->ErrorInfo;
                    header("location: ../register.php?m=3");
                } else {
                    // Espera a que el usuario confirme el correo para que haga el insert
                    $id_user = 1;
                    $encryptedPassword = $this->encryptPassword($password);
                    $queryInsertUser = '
                    insert into usuario (id_rol, email, nombres, apellido_paterno, apellido_materno, contrasena, token_activacion)
                    values ("'.$id_user.'", "'.$email.'", "'.$names.'", "'.$last_name.'", "'.$second_last_name.'", "'.$encryptedPassword.'", "'.$activation_token_hash.'");';
                    $this->query($queryInsertUser);
                    header('location: ../register.php?m=4');
                }
                ob_end_flush();
            }
        } else {
            header("location: ../register.php?m=1");  // Llenar todos los campos
        }
    }

    function validateAccount(){
        $token = $_GET['token'];
        $token_hash = hash("sha256", $token);

        $searchUser = '
            select * from usuario where token_activacion = "'.$token_hash.'"
        ';
        $user = $this->getRecord($searchUser);

        if($this->registersNum == 1){
            $update_user = 'update usuario set token_activacion = NULL where id_usuario = "'.$user->id_usuario.'"';
            $this->query($update_user);
            header("location: ../index.php?m=7"); // Confirmación de cuenta realizada correctamente
        }else{
            echo('ALGO SALIÓ MAL CONFIMRNADO EL TOKEN');
        }
    }

    function updateNewPassword(){
        $token = $_SESSION['token'];
        $token_hash = hash("sha256", $token);

        $searchUser = '
            select * from usuario where token_activacion = "'.$token_hash.'"
        ';
        $user = $this->getRecord($searchUser);
        
        if($this->registersNum == 1){
            $_SESSION['session_user_id'] = $user->id_usuario;
            $update_user = 'update usuario set token_activacion = NULL where id_usuario = "'.$user->id_usuario.'"';
            $this->query($update_user);

            $password = $_REQUEST['newPassword'];
            $password2 = $_REQUEST['newPassword2'];

            if ($password != $password2) {
                header("location: ../new-password.php?m=5"); // Las contraseñas no coinciden
            }else{
                $encryptedPassword = $this->encryptPassword($password);
                $update_user = 'update usuario set contrasena = "'.$encryptedPassword.'" where id_usuario = "'.$user->id_usuario.'"';
                $this->query($update_user);
                header("location: ../new-password.php?m=4");
            }
            
        }else{
            echo('ALGO SALIÓ MAL CONFIMRNADO EL TOKEN');
        }
    }

    function passwordRecover(){
        $email = $_POST['email'];
        if($email != null){
            if($this->emailRegistered($email)){
                ob_start();

                $activation_token = bin2hex(random_bytes(16));
                $activation_token_hash = hash("sha256", $activation_token);

                $emailHTML = 
                    '<article
                        style="background-color: #f0efef; margin: 10px; display: flex; flex-direction:column; justify-content: center; padding: 20px; border-block: solid 4px #1B396A; ">

                        <h4 style="text-align:center;">¡Hola!</h4><br>

                        <p style="text-align:center;">Recibimos tu solicitud para restablecer tu contraseña, te dirigiremos a una página donde podrás crear una nueva contraseña y recuperar el acceso a tu cuenta.</p><br>

                        <a href="https://tigger.celaya.tecnm.mx/AsesoriasInd/new-password.php?token='.$activation_token.'" style="width: 200px; padding: 10px; border-radius: 10px; margin:auto; background-color: #1B396A; color: white; border:none; cursor:pointer;">Confirmar</a>
                    </article>';
                
                

                if (!$this->sendEmail($emailHTML, $email, "Recuperacion de contrasena")) {
                    header("location: ../password-recovery.php?m=3"); // Error enviando el email
                } else {
                    $_SESSION['token'] = $activation_token;
                    $querySelectUser = "select * from usuario where email='{$email}'";
                    $user = $this->getRecord($querySelectUser);
                    $update_user = 'update usuario set token_activacion = "'.$activation_token_hash.'" where id_usuario = "'.$user->id_usuario.'"';
                    $this->query($update_user);
                    header("location: ../password-recovery.php?m=4"); // Revisar la bandeja de llegada
                }
                ob_end_flush();
            }else{
                header("location: ../password-recovery.php?m=2"); // El usuario no está registrado
            }
        }else{
            header("location: ../password-recovery.php?m=1");  // Llenar todos los campos
        }
    }

    function encryptPassword($text_plain_password) : string{
        return password_hash($text_plain_password, PASSWORD_DEFAULT);
    }

    function emailRegistered($email): bool{
        $querySelectUser = "select * from usuario where email='{$email}'";
        $this->getRecord($querySelectUser);
        if ($this->registersNum == 1) {
            return TRUE;
        }
        return FALSE;
    }

    function sendEmail($email_html, $email_destination, $email_subject) : bool {
        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->SMTPDebug  = 4;
        $mail->SMTPAuth = true;
        $mail->Username =   "alfredo.jimeneztellez9@gmail.com";
        $mail->Password = "pbek epkc njxn repo";

        $mail->From = "21030761@itcelaya.edu.mx"; // ???
        $mail->FromName = "Asesorias Dpto. Industrial"; // ???
        $mail->Subject = $email_subject;
        $mail->MsgHTML($email_html);
        $mail->AddAddress($email_destination); 

        return $mail->send();
    }

}

$access = new Class_Access();
if (isset($_REQUEST['action'])) {
    echo $access->action($_REQUEST['action']);
}

?>
