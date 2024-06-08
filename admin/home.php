<?php
session_start();
if (!isset($_SESSION['session_email']) || $_SESSION['admin'] !== TRUE) {
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
    <script src="https://kit.fontawesome.com/cdb751df44.js" crossorigin="anonymous"></script>
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
    <script src="../js/controllers/consultancies.js?v=12"></script>
    <script src="../js/controllers/users.js?v=3"></script>

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

        function displayAsideNavBar() {
            if (Aside_Bar.style.display === 'block') {
                Aside_Bar.style.display = 'none';
            } else {
                Aside_Bar.style.display = 'block';
            }
        }

        function toggleAssesoriesMenu(id_list) {
            var assesoriesList = document.getElementById(`Assesories_List_${id_list}`);
            var buttonDown = document.getElementById(`assesoriesMenuButton_Down_${id_list}`);
            var buttonUp = document.getElementById(`assesoriesMenuButton_Up_${id_list}`);

            if (assesoriesList.style.display === 'block') {
                assesoriesList.style.display = 'none';
                buttonDown.style.display = 'block';
                buttonUp.style.display = 'none';
            } else {
                assesoriesList.style.display = 'block';
                buttonDown.style.display = 'none';
                buttonUp.style.display = 'block';
            }
        }
    </script>
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
                <a class="AsideBar-Anchor anchor-default flex align-center" href="">
                    <span class="List-Item-Span margin-right-10"></span>
                    <li class="margin-block-10">
                        <i class="fa-solid fa-gear margin-right-10"></i>
                        Configuración
                    </li>
                </a>
                <a href="../login.php" class="AsideBar-Anchor anchor-default flex align-center" href="../settings.php">
                    <span class="List-Item-Span margin-right-10"></span>
                    <li class="margin-block-10">
                        <i class="fa-solid fa-right-from-bracket margin-right-10"></i>
                        Cerrar sesión
                    </li>
                </a>
            </ul>
        </aside>

        <div class="bg-light-gray flex-column justify-between width-100 height-full overflow-auto">
            <main class="overflow-auto">

                <section class="bg-primary-blue flex justify-between" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                    <h4 class="Page-Title text-white align-self-center margin-left-5">Panel de control jefe de departamento</h4>
                    <img class="Logo-Tecnm border-radius-full" src="../assets/LOGO-BLANCO-VERTICAL-TECNM.png" alt="Profile picture">

                    <button onclick="displayAsideNavBar()" class="Nav-Bar-Toogle-Button bg-bolor-unset border-none margin-right-10 cursor-pointer display-none">
                        <i class="fa-solid fa-bars text-white"></i>
                    </button>
                </section>

                <!-- <div id="workArea" class="flex-column center-flex-xy padding-20"> -->
                <div id="workArea">
                    <div style="width: 200px; margin-left: 20px;" class="flex margin-y-5 box-shadow-light border-radius-10 padding-10 bg-white place-self-end">
                        <i class="fa-solid fa-magnifying-glass margin-right-5 color-primary-blue"></i>
                        <input onkeypress="return users('searchTeacher')" id="searchTeacherInput" class="border-none" type="text" placeholder="Buscar maestro">
                    </div>

                    <?php
                    include '../classes/class_teachers.php';
                    ?>
                </div>
            </main>

            <footer class="bg-primary-blue text-white padding-5" style="border-top-left-radius: 10px; border-top-right-radius: 10px;">
                <p class="text-align-center">Hecho con ♥ por <a target="_blank" class="anchor-default" href="https://www.linkedin.com/in/alfredo-jim%C3%A9nez-01151623a/">Alfredo</a> </p>
            </footer>
        </div>
    </div>
</body>

</html>