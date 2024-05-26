<?php
session_start();
if (!isset($_SESSION['session_email'])) {
    header('location: ../login.php');
}
include '../classes/class_database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesorías</title>
    <link rel="stylesheet" href="../styles/globlal.css">
    <link rel="stylesheet" type="text/css" href="https://alfred024.github.io/CSS-mio/styles.css">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/cdb751df44.js" crossorigin="anonymous"></script>
    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <!-- JQuery confirm -->
    <script src="../controllers/jquery-confirm.js"></script>
    <link rel="stylesheet" href="../styles/jquery-confirm.css">

    <!-- Utils JS -->
    <script src="../js/utils/consultancies.js"></script>
    <!-- Custom JS -->
    <script src="../controllers/pop-up-messages.js"></script>
</head>

<body>
    <main class="flex-column height-full bg-light-gray">
        <section class="bg-primary-blue flex justify-between" style="border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
            <h4 class="text-white align-self-center margin-left-5">Asesorías</h4>
            <img class="Logo-Tecnm border-radius-full" src="./assets/LOGO-BLANCO-VERTICAL-TECNM.png" alt="Profile picture">
        </section>

        <div class="flex-column height-90 padding-20 relative" style="padding-top: 10px;">
            <div class="Assesories-Interacitve-Container flex justify-between margin-bottom-10">
                <div class="Filters-Items-Container flex align-center margin-bottom-10">
                    <div class="Teacher-Name-Filter height-fit align-center overflow-hidden flex box-shadow-light border-radius-10 padding-5 bg-white">
                        <i class="fa-solid fa-magnifying-glass margin-right-5 color-primary-blue"></i>
                        <input class="border-none" type="text" placeholder="Buscar asesoría por nombre">
                    </div>

                    <div class="Form-Date-Filter height-fit flex align-center bg-white border-radius-10 overflow-hidden" style="margin-left: 10px;">
                        <label class="font-size-10" for="input-date"><strong>Filtrar asesoría por fecha</strong></label>
                        <input class="padding-5 height-100 bg-light-gray border-none" type="date" id="input-date" name="input-date-start" value="2024–05–19">
                    </div>
                </div>

                <button onclick="return consultancies('')" class="Btn-Primary-Blue bg-primary-blue text-white padding-10 border-none">
                    Registrar nueva asesoría
                    <i class="fa-solid fa-address-card margin-left-5"></i>
                </button>
            </div>

            <!-- <div class="margin-auto" style="width: 100%; height: 70%;  overflow: scroll;"> -->
            <div class="margin-auto width-100" style="height: 70%;  overflow-y: scroll;">
                <table class="Assesories-Table overflow-x-auto padding-10 width-100" style="background-color: white;">
                    <?php
                        include "../classes/consultancies.php";
                    ?>

                </table>
            </div>

            <button class="Btn-Primary-Blue absolute bottom-0 right-0 bg-primary-blue text-white border-radius-10 padding-10 border-none">
                Descargar reporte
                <i class="fa-solid fa-download margin-left-5"></i>
            </button>
        </div>
    </main>
</body>

</html>