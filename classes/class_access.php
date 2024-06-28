<?php

if (!class_exists("Class_Database")) include "../classes/class_database.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../resources/mailer/src/SMTP.php';
require '../resources/mailer/src/PHPMailer.php';
require '../resources/mailer/src/Exception.php';

// include './class_database.php';
session_start();

class Access extends Class_Database
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
        if ($email != null && $password != null && $captcha != null) {
            if ($this->emailRegistered($email)) {
                $querySelectUser = "select * from usuario where email='{$email}'";
                $user = $this->getRecord($querySelectUser);

                if ($this->registersNum == 1) {
                    //if ($this->registersNum == 1 && password_verify($password, $user->contrasena)) {
                    $_SESSION['session_user_id'] = $user->id_usuario;
                    $_SESSION['session_email'] = $user->email;
                    $_SESSION['session_password'] = $user->contrasena;
                    $_SESSION['session_username'] = $user->nombres;
                    //echo($user->id_rol);

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
                $mail->Subject = "Confirmacion de creacion de cuenta";
                $mail->MsgHTML('
                    <article
                        style="background-color: #f0efef; margin: 10px; display: flex; flex-direction:column; justify-content: center; padding: 20px; border-block: solid 4px #1B396A; ">

                        <h4 style="text-align:center;">Bienvenido al Sistema de Asesorías del Departamento de Ingeniería Industrial</h1><br>

                        <p style="text-align:center;">Para confirmar la creación del usuario, por favor oprima el botón.</p><br>

                        <button style="width: 200px; padding: 10px; border-radius: 10px; margin:auto; background-color: #1B396A; color: white; border:none; cursor:pointer;">Confirmar</button>
                    </article>');
                $mail->AddAddress($email); // ???


                if (!$mail->send()) {
                    // echo  "Error sending the email: " . $mail->ErrorInfo;
                    header("location: ../register.php?m=3");
                } else {
                    // Espera a que el usuario confirme el correo para que haga el insert
                    $id_user = 1;
                    $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $queryInsertUser = '
                    insert into usuario (id_rol, email, nombres, apellido_paterno, apellido_materno, contrasena)
                    values ("'.$id_user.'", "'.$email.'", "'.$names.'", "'.$last_name.'", "'.$second_last_name.'", "'.$encryptedPassword.'");';
                    $this->query($queryInsertUser);
                    header('location: ../register.php?m=4');


                    // $insert_consultancie_query = '
                    // insert into asesoria
                    // (tema, competencia, descripcion, id_usuario_imparte, id_usuario_toma, clave)
                    // values ("' . $tema . '", "' . $competencia . '", "' . $description . '", "' . $user_id . '", "' . $user_id_toma . '", "' . $signature_key . '");';

                    // $this->query($insert_consultancie_query);
                }
                ob_end_flush();
            }
        } else {
            header("location: ../register.php?m=1");  // Llenar todos los campos
        }
    }

    function passwordRecover()
    {
    }

    function emailRegistered($email): bool
    {
        $querySelectUser = "select * from usuario where email='{$email}'";
        $this->getRecord($querySelectUser);
        if ($this->registersNum == 1) {
            return TRUE;
        }
        return FALSE;
    }
}

$access = new Access();
if (isset($_REQUEST['action'])) {
    echo $access->action($_REQUEST['action']);
}
