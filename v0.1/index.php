<?php
session_start();

$x = rand(100000000, 99999999999999);
$_SESSION['x'] = $x;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sami, the future is smart</title>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <meta name="description" content="100% free website generator and hosting. Developed by Goofy Technology Group">
    <meta name="keywords" content="rgmendezr, rg mendez, rg mendez r, r mendez, r g mendez r, Raúl Méndez Rodríguez">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Meta tags para Google -->
    <meta name="google" content="nositelinkssearchbox" />
    <meta name="google" content="notranslate" />

    <!-- Meta tags para Facebook -->
    <meta property="og:url" content="https://sami.almendro.cr/" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Sami, the future is smart" />
    <meta property="og:description" content="100% free website generator and hosting. Developed by Goofy Technology Group" />
    <meta property="og:image" content="https://almendro.cr/layout/images/logo-dark.svg" />

    <!-- Meta tags para Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@rgmendezr">
    <meta name="twitter:title" content="Sami, the future is smart">
    <meta name="twitter:description" content="100% free website generator and hosting. Developed by Goofy Technology Group">
    <meta name="twitter:image" content="//almendro.cr/layout/images/logo-dark.svg">

    <link rel="icon" type="image/png" href="https://almendro.cr/layout/images/logo-dark.svg" />

    <link rel="stylesheet" href="css/home.css">
    <style>
        .loader-container {
            position: relative;
            width: 100px;
            height: 100px;
        }

        /* Estilos CSS para el círculo de carga */
        .loader {
            border: 10px solid #f3f3f3;
            /* Light grey */
            border-top: 10px solid red;
            /* Blue */
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 2s linear infinite;
            margin: auto;
            position: relative;
        }

        .countdown {
            position: absolute;
            top: calc(50% - 10px);
            left: 0px;
            width: 100%;
            height: auto;
            font-size: 20px;
            color: #666;
            text-align: center;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Estilos CSS para ocultar el formulario */
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php require_once "./save/analytics.php"; ?>
    <wrapper class="wrapper">
        <div class="logo">
        </div>
        <!-- Agrega un contenedor para el círculo de carga -->
        <div class="loader-container hidden" id="loader-container">
            <div class="loader"></div>
            <!-- Agrega un elemento para mostrar el contador regresivo -->
            <div class="countdown" id="countdown">60</div>
        </div>
        <form action="go/" method="POST" enctype="application/x-www-form-urlencoded" id="form">
            <div class="container">
                <input type="hidden" name="x" value="<?= $x ?>">

                <input type="text" name="name" id="name" placeholder="Write a title" required>
                <textarea name="description" id="description" cols="30" rows="10" placeholder="Describe the site"></textarea>
                <!-- Agrega un identificador al botón para poder manipularlo con JavaScript -->
                <button type="button" id="magic-button">Make Magic</button>
            </div>
        </form>
    </wrapper>
    <footer>
        <p>© 2024 Goofy Technology Group</p>
        <p>Almendro WEB Builders</p>
    </footer>

    <!-- Script JavaScript para manejar el evento de clic en el botón -->
    <script>
        document.getElementById('magic-button').addEventListener('click', function() {

            var name = document.getElementById('name').value;
            var data = document.getElementById('description').value;

            if (name === '' || data === '') {
                alert('Please complete all fields.');
                return;
            }

            // Ocultar el formulario
            document.getElementById('form').classList.add('hidden');
            // Mostrar el contenedor del círculo de carga
            document.getElementById('loader-container').classList.remove('hidden');

            // Iniciar cuenta regresiva de 59 segundos
            var countdownElement = document.getElementById('countdown');
            var secondsLeft = 60;
            var countdownInterval = setInterval(function() {
                secondsLeft--;
                countdownElement.textContent = secondsLeft;
                if (secondsLeft <= 0) {
                    clearInterval(countdownInterval);
                }
            }, 1000);

            // Enviar el formulario
            document.getElementById('form').submit();
        });
    </script>
</body>

</html>