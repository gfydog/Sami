<?php
session_start();

$type = $_POST['type'];
if(isset($_SESSION['type'])){
    $type = $_SESSION['type'];
}

// Obtener los datos del formulario
$jsonData = array(
    'type' => $type,
    'relatedColor' => $_POST['relatedColor'],
    'language' => $_POST['language'],
    'title' => $_POST['title'],
    'nav' => array(
        'logo' => $_POST['nav']['logo'],
        'mainBtnText' => $_POST['nav']['mainBtnText'],
        'mainBtnUrl' => $_POST['nav']['mainBtnUrl'],
    ),
    'welcome' => $_POST['welcome'],
    'name' => $_POST['name'],
    'lastNames' => $_POST['lastNames'],
    'slogan' => $_POST['slogan'],
    'scroll' => $_POST['scroll'],
    'aboutMe' => array(
        'slogan' => $_POST['aboutMe']['slogan'],
        'button' => array(
            'text' => $_POST['aboutMe']['button']['text'],
            'url' => $_POST['aboutMe']['button']['url']
        ),
        'aboutMeText' => $_POST['aboutMe']['aboutMeText']
    ),
    'socialLinks' => array(
        'facebook' => array(
            'url' => $_POST['socialLinks']['facebook']['url']
        ),
        'twitter' => array(
            'url' => $_POST['socialLinks']['twitter']['url']
        ),
        'instagram' => array(
            'url' => $_POST['socialLinks']['instagram']['url']
        ),
        'web' => array(
            'url' => $_POST['socialLinks']['web']['url']
        )
    ),
    'keyAreas' => array(
        'slogan' => $_POST['keyAreas']['slogan'],
        'summary' => $_POST['keyAreas']['summary'],
        'btnText' => $_POST['keyAreas']['btnText'],
        'btnUrl' => $_POST['keyAreas']['btnUrl'],
        'details' => $_POST['areas']
    ),
    'clients' => array(
        'slogan' => $_POST['clients']['slogan'],
        'details' => $_POST['clients']['details'],
        'reviews' => $_POST['clients']['reviews']
    ),
    'callToAction' => array(
        'slogan' => $_POST['callToAction']['slogan'],
        'details' => $_POST['callToAction']['details'],
        'buttonText' => $_POST['callToAction']['buttonText'],
        'buttonUrl' => $_POST['callToAction']['buttonUrl']
    ),
    'news' => array(
        'title' => $_POST['news']['title'],
        'articles' => $_POST['articles']
    ),
    'footer' => array(
        'finalDescription' => $_POST['footer']['finalDescription'],
        'titleLinks' => $_POST['footer']['titleLinks'],
        'links' => $_POST['footer']['links']
    )
);

// Guardar los datos en la sesión
$_SESSION['html'] = $jsonData;

// Redireccionar de vuelta al editor con un mensaje de éxito
header("Location: ../sites/$type/");
exit();
?>
