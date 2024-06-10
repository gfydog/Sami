<?php
// Función para crear un archivo ZIP con los archivos especificados
function crearZip() {
    // Archivos que se incluirán en el archivo ZIP
    $archivos = [
        'index.html', // Solo el código HTML generado por index.php
        'css/styles.css',
        'css/vendor.css',
        'js/main.js',
        'js/plugins.js',
    ];

    // Nombre del archivo ZIP a crear
    $nombreZip = rand(1000,9999).'.zip';

    // Crear un nuevo objeto ZipArchive
    $zip = new ZipArchive();

    // Intentar abrir o crear el archivo ZIP
    if ($zip->open($nombreZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
        // Agregar cada archivo al archivo ZIP
        foreach ($archivos as $archivo) {
            // Obtener el contenido del archivo si es index.html
            $contenido = '';
            if ($archivo === 'index.html') {
                ob_start();
                include 'index.php'; // Generar el contenido HTML desde index.php
                $contenido = ob_get_clean();
            } else {
                $contenido = file_get_contents($archivo); // Obtener el contenido del archivo
            }

            // Agregar el archivo al ZIP
            $zip->addFromString($archivo, $contenido);
        }

        // Cerrar el archivo ZIP
        $zip->close();

        // Descargar el archivo ZIP
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $nombreZip . '"');
        readfile($nombreZip);

        // Eliminar el archivo ZIP después de descargarlo
        unlink($nombreZip);

        exit;
    } else {
        echo 'No se pudo crear el archivo ZIP';
    }
}

// Llamar a la función para crear y descargar el archivo ZIP
crearZip();
?>
