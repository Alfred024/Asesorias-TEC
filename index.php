<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Carga de Archivo</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input[type="file"] {
            display: none;
        }
        .custom-file-label {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }
        .custom-file-label:hover {
            background-color: #0056b3;
        }
        .custom-file-label i {
            margin-right: 10px;
        }
        .description {
            margin-top: 20px;
            text-align: center;
            color: #6c757d;
        }
        .btn-submit {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Subir Archivo</h1>
        <form>
            <div class="form-group">
                <label for="customFile" class="custom-file-label">
                    <i class="fas fa-upload"></i> Seleccione un archivo
                </label>
                <input type="file" id="customFile">
            </div>
            <button type="submit" class="btn-submit">Subir</button>
        </form>
        <div class="description">
            <p>Por favor, seleccione un archivo y haga clic en "Subir". Asegúrese de que el archivo cumple con los requisitos especificados.</p>
        </div>
    </div>

    <script>
        document.querySelector('.custom-file-label').addEventListener('click', function() {
            document.querySelector('#customFile').click();
        });

        document.querySelector('#customFile').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : 'Seleccione un archivo';
            document.querySelector('.custom-file-label').textContent = fileName;
            document.querySelector('.custom-file-label').insertAdjacentHTML('afterbegin', '<i class="fas fa-upload"></i> ');
        });
    </script>
</body>
</html>
