<?php
ini_set('max_execution_time', 600);
ini_set('max_input_time', 600);
ini_set('default_socket_timeout', 600);

session_start();

if (!isset($_SESSION['x'])) {
    header('location: ../#1');
    exit;
}
$x = $_SESSION['x'];
$_SESSION['x'] = rand(100000000, 99999999999999);

if (!isset($_POST['name']) || !isset($_POST['description']) || empty($_POST['name']) || !isset($_POST['x'])) {
    header('location: ../#2');
    exit;
} else if ($x != $_POST['x']) {
    header('location: ../#3');
    exit;
} else {
    define("TITLE", $_POST['name']);
    define("DATA", $_POST['description']);
}

require_once "./v5.php";
$_SESSION['html'] = $data;

if($data['aboutMe']['slogan'] == null){
    header('location: ../#23');
    exit;
}

header("location: ../admin/");
?>