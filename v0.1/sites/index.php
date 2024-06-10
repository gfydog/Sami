<?php
session_start();

if (!isset($_SESSION['html'])) {
    header('location: ../#4');
}

$data = $_SESSION['html'];

$type = 1;
if(isset($_GET['type'])){
    $type = (int)$_GET['type']; // Convierte el valor a un entero

    if(!is_int($type)){
        $type = 1;
    }
}

$_SESSION['type'] = $type;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sami</title>
    <link rel="icon" type="image/png" href="https://almendro.cr/layout/images/logo-dark.svg" />
    <style>
        *{
            padding: 0px;
            margin: 0px;
        }
        div{
            font-size: 12px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #DDD;
            color: #666;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }
        iframe{
            position: fixed;
            left: 0px;
            top: 60px;
            border: none;
            width: 100%;
            height: calc(100% - 60px);
        }
        a, select{
            padding: 5px 15px;
            border-radius: 20px;
            margin: auto 10px;
            background: linear-gradient(45deg, purple, orange);
            color: #FFF;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div><a href="../">Inicio</a> | <a href="../admin/">Abrir el editor</a> | Opciones:  
<select onchange="window.location.href = './?type='+ this.value;"> 
    <option value="1" <?= ($type == 1)? "selected":"" ?>>Original</option>
    <option value="2" <?= ($type == 2)? "selected":"" ?>>Versión 2</option>
    <option value="3" <?= ($type == 3)? "selected":"" ?>>Versión 3</option>
</select>
</div>
<iframe id="myFrame" src="../sites/<?= $type ?>/index.php">
</iframe>
<script>
    // Función para abrir enlaces en una nueva pestaña
    function openLinksInNewTab() {
        var iframe = document.getElementById('myFrame');
        var links = iframe.contentDocument.getElementsByTagName('a');
        for (var i = 0; i < links.length; i++) {
            links[i].setAttribute('target', '_blank');
        }
    }

    // Llama a la función después de que se cargue completamente el iframe
    document.getElementById('myFrame').onload = function() {
        openLinksInNewTab();
    };
</script>
</body>
</html>