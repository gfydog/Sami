<?php
session_start();

if (!isset($_GET['username'])) {
    die("Falta el parámetro 'username'.");
}

$username = $_GET['username'];

require_once "../save/cnx.php";

// Consultar datos_json por username
$consulta_json_data = $conexion->prepare("SELECT json_data FROM datos_json WHERE username = ?");
$consulta_json_data->bind_param("s", $username);
if ($consulta_json_data->execute()) {
    $consulta_json_data->bind_result($json_data);
    if ($consulta_json_data->fetch()) {
        $data = json_decode($json_data, true);
        $_SESSION['html'] = $data;
    } else {
        die("No data found for the username provided.");
    }
} else {
    die("Error retrieving data from database: " . $conexion->error);
}

// Cerrar conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $data['title'] ?></title>
    <link rel="icon" type="image/png" href="https://almendro.cr/layout/images/logo-dark.svg" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
<?php require_once "../save/analytics.php"; ?>
    <iframe id="myFrame" src="./sites/<?= $data['type'] ?>/index.php"></iframe>
    <script>
        function openLinksInParentWindow() {
            var iframe = document.getElementById('myFrame');
            var links = iframe.contentDocument.getElementsByTagName('a');
            for (var i = 0; i < links.length; i++) {
                links[i].setAttribute('target', '_parent');
            }
        }
        document.getElementById('myFrame').onload = openLinksInParentWindow;
    </script>
</body>
</html>
