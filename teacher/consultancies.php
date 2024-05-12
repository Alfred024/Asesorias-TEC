<?php
session_start();
if (!isset($_SESSION['session_email'])) {
    header('location: ../login.php');
}
include '../classes/database.php';
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

                <button class="Btn-Primary-Blue bg-primary-blue text-white padding-10 border-none">
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

        <div class="Modal-Container flex align-center justify-center absolute z-index-10 height-100 width-100">

            <form method="post" class="height-fit padding-20 box-shadow-dark flex-column justify-center bg-light-gray border-radius-30 relative" action="">
                <button onclick="return closeModal();" class="Btn-Primary-Blue absolute border-radius-full bg-primary-blue text-white border-none" style="width: 40px; height: 40px; top:0; right:0;">X</button>

                <h4 class="width-fit font-weight-600 margin-auto">Registro de una nueva asesoría para la materia X</h4>
                <hr style="margin: 10px;">

                <input name="tema" class="width-100 margin-auto box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="Tema de la asesoría"><br>

                <textarea placeholder="Escriba detalles acerca de la asesoría." class="padding-5 box-shadow-light border-none border-radius-10" style="resize: none; height:120px;" name="descripcion" id="">
                    
                </textarea><br>

                <select class="text-white padding-5 border-radius-10 bg-primary-blue" name="alumnos">
                    <!-- TODO insertar un for que muestr todos los usuarios registrados??? -->
                    <?php
                        for ($i=0; $i < 20; $i++) { 
                            echo('<option value="alumno">nombre de un alumno registrado</option>');
                        }
                    ?>
                </select><br>

                <div class="flex justify-between">
                    <select class="text-white padding-5 border-radius-10 bg-primary-blue" name="competencias" style="width: 30%;">
                        <option value="competencia_1">1</option>
                        <option value="competencia_2">2</option>
                        <option value="competencia_3">3</option>
                        <option value="competencia_4">4</option>
                        <option value="competencia_5">5</option>
                        <option value="competencia_6">6</option>
                    </select>

                    <select class="text-white padding-5 border-radius-10 bg-primary-blue" name="periodo" id="" style="width: 60%;">
                        <option value="enero_junio">Enero - Junio</option>
                        <option value="agosto_diciembre">Agosto - Diciembre</option>
                    </select>
                </div>
                <br>

                <input type="hidden" name="action" value="insert">
                <input type="submit" class="Btn-Primary-Blue bg-primary-blue text-white border-radius-20 padding-10 border-none margin-auto" value="Registrar Materia" style="width: 200px;">
            </form>
        </div>
    </main>
</body>

</html>