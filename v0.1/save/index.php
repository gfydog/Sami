<?php
session_start(); // Iniciar sesión si no está iniciada

require_once "cnx.php";

function generarStringAleatorio($longitud)
{
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $longitudCaracteres = strlen($caracteres);
    $cadenaAleatoria = '';

    for ($i = 0; $i < $longitud; $i++) {
        $indiceAleatorio = rand(0, $longitudCaracteres - 1);
        $cadenaAleatoria .= $caracteres[$indiceAleatorio];
    }

    return $cadenaAleatoria;
}

// Validar entrada POST
if (isset($_POST['username'], $_SESSION['html'])) {
    $username = $_POST['username'];

    $jsonData = json_encode($_SESSION['html']);

    // Verificar si se proporciona un key_code
    if (isset($_POST['key_code']) && !empty($_POST['key_code'])) {
        $key_code = $_POST['key_code'];
        // Actualizar los datos existentes
        $consulta = $conexion->prepare("UPDATE datos_json SET json_data = ?, username = ? WHERE key_code = ?");
        $consulta->bind_param("sss", $jsonData, $username, $key_code);
    } else {
        $is = true;
        // Generar clave única para key_code
        $key_code = generarStringAleatorio(100);
        // Insertar nuevos datos con key_code generado
        if (!isset($_POST['email'])) {
            die("Error: Falta el email.");
        }
        $email = $_POST['email'];

        $consulta = $conexion->prepare("INSERT INTO datos_json (json_data, username, email, key_code) VALUES (?, ?, ?, ?)");
        $consulta->bind_param("ssss", $jsonData, $username, $email, $key_code);
    }

    // Ejecutar consulta
    if ($consulta->execute()) {
        // Éxito en la ejecución de la consulta

        if (isset($is)) {
            // Generar el enlace de edición
            $edit_link = $edit_base_url . $key_code;
            // Enviar correo electrónico con el enlace de edición
            $to = $email;
            $subject = "Link to edit your site";
            $message = "Hi $username,\n\n";
            $message .= "Thank you for using our services! \n\nTo edit your site, you can access the following link:\n";
            $message .= $edit_link;
            $headers = "From: contact@gfy.dog";
            mail($to, $subject, $message, $headers);
        }

        session_unset();
        session_destroy();

        // Mostrar página de éxito
?>
        <!DOCTYPE html>
        <html lang="es">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Sami</title>
            <link rel="icon" type="image/png" href="https://almendro.cr/layout/images/logo-dark.svg" />
            <style>
                body {
                    background-color: #1a1a1a;
                    color: #ffffff;
                    font-family: Arial, sans-serif;
                    text-align: center;
                    padding-top: 50px;
                }

                .container {
                    max-width: 600px;
                    margin: 0 auto;
                }

                .button {
                    background: linear-gradient(45deg, purple, orange);
                    border: none;
                    color: white;
                    padding: 15px 32px;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    font-size: 16px;
                    margin: 4px 2px;
                    cursor: pointer;
                    border-radius: 8px;
                }
            </style>
        </head>

        <body>
            <?php require_once "./analytics.php"; ?>
            <div class="container">
                <h1>Process carried out successfully</h1>
                <p>Thank you for using our services!</p>
                <a class="button" target="_blank" href="../<?= $username ?>">See the site</a>
                <p>Consider making a donation to support the project:</p>

                <form action="https://www.paypal.com/donate" method="post" target="_blank">
                    <input type="hidden" name="business" value="raul301095@gmail.com">
                    <input type="hidden" name="currency_code" value="USD">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypal.com/es_XC/i/scr/pixel.gif" width="1" height="1">
                </form>

            </div>
        </body>

        </html>
<?php
    } else {
        die("Error saving or updating data in database:" . $conexion->error);
    }
} else {
    die("Input data missing");
}

if (isset($consulta)) {
    $consulta->close();
}
?>