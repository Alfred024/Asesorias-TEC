<?php 
	session_start();
	session_destroy();
	if (!isset($_SESSION['token'])) {
		header('location: ../index.php'); // No tienes autorización de entrar a esta página
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="./assets/logo-II.png" type="image/png">
	<title>Recuperación de Contraseña</title>
	<link rel="stylesheet" type="text/css" href="./styles/globlal.css">
	<link rel="stylesheet" type="text/css" href="https://alfred024.github.io/CSS-mio/styles.css">
	
	<!-- Google fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
	<img class="Logo-Tecnm absolute" src="./assets/LOGO-VERTICAL-TECNM.png" alt="Logo ITC">
	<section class="Form-Page-Section flex">

		<div class="Form-Container flex flex-column center-flex-xy width-100 height-full">
			
			<form method="post" action="./classes/class_access.php" class="Form box-shadow-light flex-column justify-center bg-light-gray border-radius-30">
				<div class="width-80 margin-auto">
					<h1 class="font-weight-600 margin-bottom-10" >Recuperación de Contraseña</h1>
				</div>

				<label class="flex-column width-80 margin-auto">
					Correo
					<br>
					<input name="email" 
						class="input-1" 
						type="email" placeholder="juan.montes@itcelaya.edu.mx" required>
				</label>

				<div class="width-80 margin-auto margin-block-10">
					<a class="anchor-default text-secondary-blue margin-bottom-10 font-size-15 " href="./login.php" target="_blank">Volver al inicio de sesión</a>
				</div>

				<input type="hidden" name="action" value="passwordRecover">
				<input class="Btn-Primary-Blue bg-primary-blue text-white border-radius-10 padding-10 border-none margin-auto" type="submit" value="Enviar" style="width: 200px;">

				<?php
					if(isset($_GET['m'])){
						$message = $_GET['m'];

						switch ($message) {
							case '1':
								echo(
									'<span 
										class="text-secondary-blue margin-top-10"
										style="font-size: 15px; font-weight:600; text-align: center;">
										Favor de llenar todos los campos
									</span>'
								);
							break;
							case '2':
								echo(
									'<span 
										class="text-secondary-blue margin-top-10"
										style="font-size: 15px; font-weight:600; text-align: center;">
										El usuario no está registrado
									</span>'
								);
							break;
							case '3':
								echo(
									'<span 
										class="text-secondary-blue margin-top-10"
										style="font-size: 15px; font-weight:600; text-align: center;">
										Error al enviar el correo de recuperación. Inténtalo de nuevo.
									</span>'
								);
							break;
							case '4':
								echo(
									'<span 
										class="text-secondary-blue margin-top-10"
										style="font-size: 15px; font-weight:600; text-align: center;">
										Correo de recuperación enviado. Revisa tu bandeja de entrada.
									</span>'
								);
							break;
						}
					}
				?> 
				
				<div class="flex center-flex-xy margin-top-10">
					<span class="font-size-15 margin-right-5">¿Aún no tienes cuenta?</span>
					<a href="./register.php" class="Anchor-Form anchor-default font-size-15 text-secondary-blue">Crea una aquí</a>
				</div>
			</form>
		</div>

		<div class="Img-Container bg-cover bg-center width-100 height-full">
			<div class="Shadow-Div bg-black width-100 height-100"></div>
		</div>
	</section>

</body>
</html>
