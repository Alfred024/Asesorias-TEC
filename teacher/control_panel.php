<?php 
    session_start();
    if(!isset($_SESSION['session_email'])){
        header('location: ../login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Control panel</title>
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
</head>
<body>
    <div class="Control-Panel-Container flex">
        <aside id="Aside-Bar" class="Aside-Bar height-full" style="width: 250px;">
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
               <a class="AsideBar-Anchor anchor-default flex align-center" href="../settings.php">
                    <span class="List-Item-Span margin-right-10"></span>
                    <li class="margin-block-10">
                        <i class="fa-solid fa-gear margin-right-10"></i>
                        Configuración
                    </li>
               </a>
            </ul>
        </aside>

        <div class="bg-light-gray flex-column justify-between width-100 height-full overflow-auto">
            <main class="overflow-auto">
                <section class="bg-primary-blue flex justify-between" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <h4 class="Page-Title text-white align-self-center margin-left-5">Panel de control maestro</h4>
                    <img class="Logo-Tecnm border-radius-full" src="./assets/LOGO-BLANCO-VERTICAL-TECNM.png" alt="Profile picture">
    
                    <button onclick="displayAsideNavBar()" class="Nav-Bar-Toogle-Button bg-bolor-unset border-none margin-right-10 cursor-pointer display-none">
                        <i class="fa-solid fa-bars text-white"></i>
                    </button>
                </section>
    
                <!-- SUBJECTS CARD SECTION -->
                <section class="Subject-Section padding-20 relative">
                    <h4 class="font-weight-400">Materias registradas</h4>
                    <br>

                    <!-- <div class="Subjects-Card-Container overflow-auto width-90">
    
                        <div class="Subject-Card anchor-default margin-right-10 bg-primary-blue border-radius-30 text-white overflow-hidden">
                            <div class="flex-column justify-between padding-10" style="height: 80%;">
                                <p>Materia: Simulación</p>
                                <p class="font-size-15 text-light">GRUPO: A</p>
                            </div>
                            <div class="bg-secondary-blue" style="height: 20%;">
                                <p class="text-align-end" style="padding-right: 20px;">Clave: GG1A</p>
                            </div>
                        </div> 
    
                    </div> -->
                    <?php 
                        //Agregar if, si no encuentra materias: echo(<h1 class="padding-20 text-align-center color-primary-blue">Aún no tienes materias registradas, pulsa el botón "´´"</h1>)
                        include '../classes/signatures.php';
                    ?>

                    <button onclick="openModal()" class="Add-Subject-Button absolute border-radius-full" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </section>
    
                <section class="Assesories-Table-Section padding-20" style="padding-top: 0px; margin-top: 30px;">
                    <h4 class="font-weight-400" style="margin-bottom: 10px;">Asesorías agregadas recientemente</h4>
                    <table class="Assesories-Table overflow-x-auto border-radius-20 padding-10 width-100" style="background-color: white;">
                        <thead class="Table-Header">
                            <tr class="text-secondary-blue">
                                <th>Materia</th>
                                <th>Alumno</th>
                                <th>Competencia</th>
                                <th>Tema</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
    
                        <tbody>
                            <!-- ESTO ES UNA ASESORÍA -->
                            <tr class="">
                                <td>Simulación</td>
                                <td>Jiménez Téllez José Alfredo</td>
                                <td>1</td>
                                <td>Monte Carlo</td>
                                <td>Fri Mar 15 2024</td>
                            </tr>
                            <!-- <div class="table-row-div"></div> -->
                            <tr>
                                <td>Simulación</td>
                                <td>Jiménez Téllez José Alfredo</td>
                                <td>1</td>
                                <td>Monte Carlo</td>
                                <td>Fri Mar 15 2024</td>
                            </tr>
    
                            <tr>
                                <td>Simulación</td>
                                <td>Jiménez Téllez José Alfredo</td>
                                <td>1</td>
                                <td>Monte Carlo</td>
                                <td>Fri Mar 15 2024</td>
                            </tr>
    
                            <tr>
                                <td>Simulación</td>
                                <td>Jiménez Téllez José Alfredo</td>
                                <td>1</td>
                                <td>Monte Carlo</td>
                                <td>Fri Mar 15 2024</td>
                            </tr>
    
                            <tr>
                                <td>Simulación</td>
                                <td>Jiménez Téllez José Alfredo</td>
                                <td>1</td>
                                <td>Monte Carlo</td>
                                <td>Fri Mar 15 2024</td>
                            </tr>
    
                            <tr>
                                <td>Simulación</td>
                                <td>Jiménez Téllez José Alfredo</td>
                                <td>1</td>
                                <td>Monte Carlo</td>
                                <td>Fri Mar 15 2024</td>
                            </tr>
    
                            <tr>
                                <td>Simulación</td>
                                <td>Jiménez Téllez José Alfredo</td>
                                <td>1</td>
                                <td>Monte Carlo</td>
                                <td>Fri Mar 15 2024</td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </main>


            <footer class="bg-primary-blue text-white padding-5" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <p class="text-align-center">Hecho con ♥ por <a target="_blank" class="anchor-default" href="https://www.linkedin.com/in/alfredo-jim%C3%A9nez-01151623a/">Alfredo</a> </p>
            </footer>
        </div>
        
    </div>

    <script>
        // Manejar el display del asideBar
        var asideBar = document.getElementById('Aside-Bar');
        var mediaQuery = window.matchMedia('(min-width: 750px)');
        var handleMediaQueryChange = function(mediaQuery) {
            if (mediaQuery.matches) {
                asideBar.style.display = 'block';
            } else {
                asideBar.style.display = 'none';
            }
        };
        mediaQuery.addListener(handleMediaQueryChange);

        function openModal(){
            var modal = document.getElementById('Modal-Container-Id');
            // modal.style.display = 'flex !important';
            modal.style.display = 'block !important';
        }

        function displayAsideNavBar(){
            var asideBar = document.getElementById('Aside-Bar');
            if(asideBar.style.display === 'block'){
                asideBar.style.display = 'none';
            }else{
                asideBar.style.display = 'block';
            }
        }
    </script> 
</body>
</html>