<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../resources/mailer/src/SMTP.php';
require '../resources/mailer/src/PHPMailer.php';
require '../resources/mailer/src/Exception.php';

include './class_database.php';
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

    function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $captcha = $_POST['captcha'];

        // TODO: Método comprobar que los campos no estén vaciós
        if ($email != null && $password != null && $captcha != null) {
            if ($this->emailRegistered($email)) {
                $querySelectUser = "select * from usuario where email='{$email}' and contrasena='{$password}'";
                $user = $this->getRecord($querySelectUser);

                if ($this->registersNum == 1) {
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
                    header("location: ../login.php?m=3"); // Datos inválidos, pruebe a escribir los datos de nuevo
                }
            } else {
                header("location: ../login.php?m=2"); // El usuario no está registrado
            }
        } else {
            header("location: ../login.php?m=1");  // Llenar todos los campos
        }
    }

    function register()
    {
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

                $mail = new PHPMailer(true);
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'alfredo.jimeneztellez9@gmail.com';                     //SMTP username
                $mail->Password   = 'pbek epkc njxn repo';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom($email, 'Mailer');
                $mail->addAddress('alfredo.jimeneztellez9@gmail.com', 'Alfredo User');     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                // $mail->IsSMTP();
                // $mail->Host = "smtp.gmail.com";
                // $mail->SMTPSecure = 'ssl';
                // $mail->Port = 465;
                // $mail->SMTPDebug  = 4;
                // $mail->SMTPAuth = true;
                // $mail->Username =   "alfredo.jimeneztellez9@gmail.com";
                // $mail->Password = "pbek epkc njxn repo";

                // $mail->From = "21030761@itcelaya.edu.mx"; // ???
                // $mail->FromName = "ADMIN BASTA"; // ???
                // $mail->Subject = "Registro de sistema basta completo";
                // $mail->MsgHTML("<h1>BIENVENIDO " . $_REQUEST['names'] . " " . $_REQUEST['last_name'] . "</h1><h2> tu clave de acceso es : " . $password . "</h2>");
                // $mail->AddAddress($email);

                if (!$mail->send()) {
                    echo  "Error sending the email: " . $mail->ErrorInfo;
                    header("location: ../register.php?m=3"); // El registro no puedo realizarse con éxito
                } else {
                    $queryInsertUser = "insert into usuario (id_rol, email, nombres, apellido_paterno, apellido_materno, contrasena)
                        values (1, '{$email}', '{$names}', '{$last_name}', '{$second_last_name}', '{$password}');";
                    $this->query($queryInsertUser);
                    header('location: ../register.php?m=4');
                }
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
