<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Formulario registro</title>

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

		<div class="Form-Container flex center-flex-xy width-100 height-full">
			<form method="post" class="Form box-shadow-dark flex-column justify-center bg-light-gray border-radius-30">
				<h4 class="width-fit font-weight-600 margin-auto" >Registro </h4>
				<hr style="margin: 10px;">

				<label class="flex-column width-80 margin-auto">
					Nombre
					<br>
					<input name="nombres" class="box-shadow-light border-radius-20 padding-5 border-none" type="text" placeholder="">
				</label><br>

				<div class="flex width-80 margin-auto">
					<label class="flex-column margin-auto margin-right-10">
						Apellido Paterno
						<br>
						<input name="apellido_paterno" class="box-shadow-light border-radius-20 padding-5 border-none" type="text" placeholder="">
					</label>
	
					<label class="flex-column margin-auto">
						Apellido Materno
						<br>
						<input name="apellido_materno" class="box-shadow-light border-radius-20 padding-5 border-none" type="text" placeholder="">
					</label>
				</div><br>

				<label class="flex-column width-80 margin-auto">
					TECnM email
					<br>
					<input name="email" class="box-shadow-light border-radius-20 padding-5 border-none" type="text" placeholder="juan.montes@itcelaya.edu.mx">
				</label><br>

				<label class="flex-column width-80 margin-auto">
					Contraseña
					<br>
					<input name="contrasena" class="box-shadow-light border-radius-20 padding-5 border-none" type="password" placeholder="">
				</label><br>

				<label class="flex-column width-80 margin-auto">
					Confirmar contraseña
					<br>
					<input name="contrasena" class="box-shadow-light border-radius-20 padding-5 border-none" type="password" placeholder="">
				</label><br>

				<div class="Captcha-Container padding-5 flex justify-between align-center width-60 border-radius-10 margin-auto">
					<div class="flex">
						<input class="margin-right-10" type="checkbox" name="" id="">
						<p>No soy un robot</p>
					</div>
					<img src="./assets/recaptcha.png" alt="Recaptcha logo" style="width: 35px;">
				</div><br>

				<input class="Btn-Primary-Blue bg-primary-blue text-white border-radius-20 padding-10 border-none margin-auto" type="submit" value="Registrar" style="width: 200px;">

				<div class="flex center-flex-xy margin-top-10">
					<span class="font-size-15 margin-right-5">¿Ya tienes una cuenta?</span>
					<a class="Anchor-Form font-size-15 text-secondary-blue">Acceder</a>
				</div>
			</form>
		</div>

		<div class="Img-Container bg-cover bg-center width-100 height-full">
			<div class="Shadow-Div bg-black width-100 height-100"></div>
		</div>
	</section>

	<script src="./scripts/register.js"></script>
</body>
</html>
