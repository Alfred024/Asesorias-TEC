<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="./assets/logo-II.png" type="image/png">
	<title>Asesorías Industrial</title>

	<link rel="stylesheet" type="text/css" href="./styles/globlal.css">
	<link rel="stylesheet" type="text/css" href="https://alfred024.github.io/CSS-mio/styles.css">

	<!-- Google fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

	<!-- JS -->
	 <script src="./js/controllers/users.js"></script>
</head>
<body>
	<img class="Logo-Tecnm absolute" src="./assets/LOGO-VERTICAL-TECNM.png" alt="Logo ITC">
	<section class="Form-Page-Section flex">

		<div class="Form-Container flex center-flex-xy width-100 height-full">

			<form method="post" action="./classes/access.php" class="Form box-shadow-dark flex-column justify-center bg-light-gray border-radius-30">
				<h4 class="width-fit font-weight-600 margin-auto" >Registro </h4>
				<hr class="margin-y-5">

				<label class="flex-column width-80 margin-auto">
					Nombre
					<input name="names" class="input-1" type="text" placeholder="">
				</label>

				<div class="flex justify-between width-80 margin-auto">
					<label class="flex-column margin-right-5">
						Apellido Paterno
						<input name="last_name" class="input-1" type="text" placeholder="">
					</label>
	
					<label class="flex-column">
						Apellido Materno
						<input name="second_last_name" class="input-1" type="text" placeholder="">
					</label>
				</div><br>

				<label class="flex-column width-80 margin-auto">
					TECnM email
					<input 
						id="emailId"
						name="email" class="input-1" type="email" placeholder="juan.montes@itcelaya.edu.mx">
						<span id="message"></span>
				</label>

				<label class="flex-column width-80 margin-auto">
					Contraseña (Mandar contraseña al correo)
					<input name="password" class="input-1" type="password" placeholder="">
				</label>

				<label class="flex-column width-80 margin-auto">
					Confirmar contraseña
					<input name="password2" class="input-1" type="password" placeholder="">
				</label>

				<div class="Captcha-Container padding-5 flex justify-between align-center width-60 border-radius-10 margin-auto margin-top-5">
					<div class="flex">
						<input name="captcha" class="margin-right-10" type="checkbox">
						<p>No soy un robot</p>
					</div>
					<img src="./assets/recaptcha.png" alt="Recaptcha logo" style="width: 35px;">
				</div>

				<input type="hidden" name="action" value="register">
				<input 
					onclick="return users('validateEmail');"
					class="Btn-Primary-Blue margin-top-5 bg-primary-blue text-white border-radius-10 padding-10 border-none margin-auto" type="submit" value="Registrar" style="width: 200px;">

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
										El usuario ya está registrado
									</span>'
								);
							break;
							case '3':
								echo(
									'<span 
										class="text-secondary-blue margin-top-10"
										style="font-size: 15px; font-weight:600; text-align: center;">
										Algo salió mal en el registro, compruebe su correo electrónico
									</span>'
								);
							break;
							case '4':
								echo(
									'<span 
										class="text-secondary-blue margin-top-10"
										style="font-size: 15px; font-weight:600; text-align: center;">
										El registro se realizó con éxito
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

				<div class="flex center-flex-xy margin-top-5">
					<span class="font-size-15 margin-right-5">¿Ya tienes una cuenta?</span>
					<a href="./index.php" class="Anchor-Form anchor-default font-size-15 text-secondary-blue">Acceder</a>
				</div>
			</form>
			
		</div>

		<div class="Img-Container bg-cover bg-center width-100 height-full">
			<div class="Shadow-Div bg-black width-100 height-100"></div>
		</div>
	</section>
</body>
</html>
