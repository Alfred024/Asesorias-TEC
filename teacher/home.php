<?php 
    session_start();
    if(!isset($_SESSION['session_email'])){
        header('location: ../index.php?m=9');
    }

    // include "../classes/class_database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../assets/logo-II.png" type="image/png">
    <title>Asesorías Industrial</title>
    <link rel="stylesheet" href="../styles/globlal.css">
    <link rel="stylesheet" href="https://alfred024.github.io/CSS-mio/styles.css">
    <!-- Font Awesome -->
    <script
      src="https://kit.fontawesome.com/cdb751df44.js"
      crossorigin="anonymous"
    ></script>
    <!-- Google fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- JQuery confirm -->
    <script src="../js/utils/jquery-confirm.js"></script>
    <link rel="stylesheet" href="../styles/jquery-confirm.css">

    <!-- Controllers JS -->
    <script src="../js/controllers/signatures.js?v=10"></script>
    <script src="../js/controllers/consultancies.js?v=12"></script>
    <!-- Custom JS -->
    <script src="../js/utils/custom-jquery.js"></script>
    <script src="../js/utils/change-pages.js?v=4"></script>
    <script src="../js/utils/loading-skeletons.js"></script>
</head>
<body>
    <div class="Control-Panel-Container flex">
        <aside id="Aside_Bar" class="Aside-Bar height-full" style="width: 250px;">
            <h3 class="padding-20">Registro de asesorías ITC</h3>
            <ul class="" style="margin-top: 30px;">

                <!-- CORREGIR LOS ANCHORS POR LI´s -->
                <a class="AsideBar-Anchor AsideBar-Anchor-Selected anchor-default flex align-center" href="" style="height: 60px;">
                    <span class="List-Item-Span margin-right-10"></span>
                    <li class="margin-block-10">
                        <i class="fa-solid fa-house margin-right-10"></i>
                        Inicio
                    </li>
                </a>
                <a 
                    onclick="return load_page('excel');"
                    id="ExcelId"
                    class="AsideBar-Anchor anchor-default flex align-center">
                    <span class="List-Item-Span margin-right-10"></span>
                    <li class="margin-block-10">
                        <i class="fa-regular fa-file-excel margin-right-10"></i>
                        Registrar alumnos
                    </li>
               </a>
               <a 
                    onclick="return load_page('settings');"
                    id="SettingsId"
                    class="AsideBar-Anchor anchor-default flex align-center">
                    <span class="List-Item-Span margin-right-10"></span>
                    <li class="margin-block-10">
                        <i class="fa-solid fa-gear margin-right-10"></i>
                        Configuración
                    </li>
               </a>
               <a href="../index.php" class="AsideBar-Anchor anchor-default flex align-center">
                    <span class="List-Item-Span margin-right-10"></span>
                    <li class="margin-block-10">
                        <i class="fa-solid fa-right-from-bracket margin-right-10"></i>
                        Cerrar sesión
                    </li>
               </a>
            </ul>
        </aside>
    
        <div class="bg-light-gray flex-column justify-between width-100 height-full overflow-auto">
            <main class="overflow-auto height-100">
                <section class="bg-primary-blue flex justify-between" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <h4 class="Page-Title text-white align-self-center margin-left-5">Panel de control maestro</h4>
                    <img class="Logo-Tecnm border-radius-full" src="../assets/LOGO-BLANCO-VERTICAL-TECNM.png" alt="Profile picture">
    
                    <button onclick="displayAsideNavBar()" class="Nav-Bar-Toogle-Button bg-bolor-unset border-none margin-right-10 cursor-pointer display-none">
                        <i class="fa-solid fa-bars text-white"></i>
                    </button>
                </section>
    
                <!-- SUBJECTS CARD SECTION -->
                <div class="height-90" id="workArea">
                    <section class="Subject-Section padding-20 relative">
                        <h4 class="font-weight-400">Materias registradas</h4>
                        <br>

                        <?php 
                            include '../classes/class_signatures.php';
                        ?>
                    </section>
        
                    <section class="Assesories-Table-Section padding-20">
                        <h4 class="font-weight-400 margin-bottom-10">Asesorías recientes</h4>
                        <?php 
                            include '../classes/class_consultancies.php';
                        ?>
                    </section>
                </div>
            </main>


            <footer class="bg-primary-blue text-white padding-5" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <p class="text-align-center">Hecho con ♥ por <a target="_blank" class="anchor-default text-white" href="https://www.linkedin.com/in/alfredo-jim%C3%A9nez-01151623a/">Alfredo</a> </p>
            </footer>
            
        </div>
        
    </div>

    <script>
        var mediaQuery = window.matchMedia('(min-width: 750px)');
        var handleMediaQueryChange = function(mediaQuery) {
            if (mediaQuery.matches) {
                Aside_Bar.style.display = 'block';
            } else {
                Aside_Bar.style.display = 'none';
            }
        };
        mediaQuery.addListener(handleMediaQueryChange);

        function displayAsideNavBar(){
            if(Aside_Bar.style.display === 'block'){
                Aside_Bar.style.display = 'none';
            }else{
                Aside_Bar.style.display = 'block';
            }
        }
    </script> 
</body>
</html>

