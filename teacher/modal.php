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
    <div id="Modal-Container-Id" 
        class="Modal-Container absolute z-index-10 relative height-full width-100 flex center-flex-xy" 
        style="background-color: rgba(32,35,41,.8); top:0; bottom:0; left:0; right:0;">
        <form class="padding-20 box-shadow-dark flex-column justify-center bg-light-gray border-radius-30 relative" action="" style="width: 320px;">
            <button class="Btn-Primary-Blue absolute border-radius-full bg-primary-blue text-white border-none" style="width: 40px; height: 40px; top:0; right:0;">X</button>
        
            <h4 class="width-fit font-weight-600 margin-auto" >Registro de maestro</h4>
            <hr style="margin: 10px;">

            <label class="flex-column width-100 margin-auto">
                Nombre de la materia
                <br>
                <input class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
            </label><br>

            <div class="flex justify-center">
                <label class="flex-column width-40 margin-auto">
                    Clave de la materia
                    <br>
                    <input class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
                </label>
    
                <label class="flex-column width-40 margin-auto">
                    Grupo
                    <br>
                    <input class="box-shadow-light border-radius-20 padding-10 border-none" type="text" placeholder="">
                </label>
            </div>
            <br>

            <input class="Btn-Primary-Blue bg-primary-blue text-white border-radius-20 padding-10 border-none margin-auto" type="submit" value="Registrar Materia" style="width: 200px;">
        </form>
    </div>
</body>
</html>