<?php

$host = "localhost";
$usuario = "root";
$contrasena = "";
$nombreBaseDatos = "sami";
$edit_base_url = "http://localhost/GoofyStores/Sami/Sami/v1.0/admin/?key_code=";

$conexion = new mysqli($host, $usuario, $contrasena, $nombreBaseDatos);
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
