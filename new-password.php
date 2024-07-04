<?php 
	session_start();
	session_destroy();
	// if (!isset($_SESSION['token']) || ($_SESSION['token'] != $_GET['token'])) {
	if (!isset($_GET['token'])) {
		header('location: ./index.php'); // No tienes autorización de entrar a esta página
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="./assets/logo-II.png" type="image/png">
	<title>Creación de nueva contraseña</title>
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
					Nueva contraseña
					<br>
					<input name="newPassword" 
						class="input-1" 
						type="password" required>
				</label><br>

				<label class="flex-column width-80 margin-auto">
					Confirmación de nueva contraseña
					<br>
					<input name="newPassword2" 
						class="input-1" 
						type="password" required>
				</label>


				<input type="hidden" name="action" value="updateNewPassword">
				<input class="Btn-Primary-Blue bg-primary-blue text-white border-radius-10 padding-10 border-none margin-auto" type="submit" value="Actualizar" style="width: 200px;">

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
										La contraseña se actualizó exitosamente.
									</span>'
								);
							break;
							case '5':
								echo(
									'<span 
										class="text-secondary-blue margin-top-10"
										style="font-size: 15px; font-weight:600; text-align: center;">
										Las contraseñas no coinciden
									</span>'
								);
							break;
						}
					}
				?> 
			</form>
		</div>

		<div class="Img-Container bg-cover bg-center width-100 height-full">
			<div class="Shadow-Div bg-black width-100 height-100"></div>
		</div>
	</section>

</body>
</html>
