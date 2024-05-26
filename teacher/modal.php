<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modal DEMO</title>
    <link rel="stylesheet" href="../styles/globlal.css">
    <link rel="stylesheet" type="text/css" href="https://alfred024.github.io/CSS-mio/styles.css">
</head>

<body>

    <!-- <style>
        .Modal-Container{
            /* display: none !important; */
            position: absolute !important;
            background-color: rgba(32,35,41,.8);
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
    </style> -->

    <!-- MODAL CONTAINER -->
    <div id="Modal-Container-Id" class="Modal-Container absolute z-index-10 relative height-full width-100 flex center-flex-xy" style="background-color: rgba(32,35,41,.8); top:0; bottom:0; left:0; right:0;">
        <form class="padding-20 box-shadow-dark flex-column justify-center bg-light-gray border-radius-30 relative" action="" style="width: 320px;">
            <button class="Btn-Primary-Blue absolute border-radius-full bg-primary-blue text-white border-none" style="width: 40px; height: 40px; top:0; right:0;">X</button>

            <h4 class="width-fit font-weight-600 margin-auto">Registro de asesoría</h4>
            <hr style="margin: 10px;">

            <input class="width-100 margin-auto box-shadow-light border-radius-20 padding-5 border-none" type="text" name="tema" placeholder="Tema de la asesoría">
            <br>

            <div class="flex gap-10">
                <label class="flex-column margin-auto">
                    Competencia
                    <br>
                    <select class="box-shadow-light border-radius-20 padding-5 border-none" name="competencia">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                    </select>
                </label>

                <label class="flex-column margin-auto">
                    Periodo
                    <br>
                    <select class="box-shadow-light border-radius-20 padding-5 border-none" name="id_periodo">
                        <option value="1">Enero-Junio</option>
                        <option value="2">Agosto-Diciembre</option>
                    </select>
                </label>
            </div>
            <br>

            <textarea style="height: 100px;" class="width-100 margin-auto box-shadow-light border-radius-20 padding-5 border-none" name="descripcion" placeholder="Descripción de la asesoría"></textarea>
            <br>

            <label class="flex-column width-100 margin-auto">
                Alumno que toma la asesoría
                <br>
                <select class="box-shadow-light border-radius-20 padding-5 border-none" name="alumno">
                    <?php 
                        for ($i=0; $i < 3; $i++) { 
                            echo('<option value="1">Juan Pérez Barrera</option>');
                        }
                    ?>
                </select>
            </label><br>

            <input class="Btn-Primary-Blue bg-primary-blue text-white border-radius-20 padding-10 border-none margin-auto" type="submit" value="Registrar Asesoría" style="width: 200px;">
        </form>

    </div>
</body>

</html>