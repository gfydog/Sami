<?php
session_start();

// Fetch existing data if key_code is provided
if (isset($_GET['key_code'])) {
    $key_code = $_GET['key_code'];
    require_once "../save/cnx.php";

    $stmt = $conexion->prepare("SELECT json_data, username FROM datos_json WHERE key_code = ?");
    $stmt->bind_param("s", $key_code);
    $stmt->execute();
    $stmt->bind_result($json_data, $username);
    $stmt->fetch();

    if ($json_data) {
        $_SESSION['html'] = json_decode($json_data, true);
    } else {
        die("No data found for the provided key code.");
    }
}

// Redirect if no session data
if (!isset($_SESSION['html'])) {
    header('location: ../#4');
    exit;
}

// Get data and type
$data = $_SESSION['html'];
$type = $data['type'];

// Handle type selection
if (isset($_GET['type'])) {
    $type = (int)$_GET['type'];
    if (!is_int($type)) {
        $type = 1;
    }
} else if (isset($_SESSION['type'])) {
    $type = $_SESSION['type'];
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
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f9f9f9;
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            display: flex;
            height: 100%;
            flex-wrap: nowrap;
        }

        .half {
            height: 100%;
        }

        .left {
            width: 30%;
            overflow-y: auto;
        }

        .right {
            width: 70%;
            background-color: #000;
            /* Morado */
            overflow: hidden;
        }

        .iframe {
            width: 100%;
            height: 100%;
        }

        .wrapper {
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
        }

        label {
            margin-bottom: 10px;
            font-size: 11px;
        }

        input,
        textarea,
        select {
            background-color: #f0f0f0;
            color: #666;
            border: 1px solid #666;
            border-radius: 10px;
            padding: 10px;
            border-radius: 5px;
            width: calc(100% - 20px);
            margin: 5px auto;
        }

        button {
            background-color: #0078d4;
            color: #ffffff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .h1 {
            margin-top: 150px;
        }

        h1 {
            text-align: center;
        }

        h2 {
            text-align: center;
            font-size: 12px;
            margin-top: 10px;
        }

        .btn-s {
            background: linear-gradient(45deg, purple, orange);
            margin-top: 10px;
            width: 90%;
        }

        .a,
        .select {
            padding: 5px 0px;
            border-radius: 5px;
            background: linear-gradient(45deg, purple, orange);
            color: #FFF;
            text-decoration: none;
            font-size: 11px;
            font-weight: bold;
            margin: 3px 3%;
            width: 23%;
            text-align: center;
        }

        .options {
            text-align: center;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            position: fixed;
            top: 0px;
            left: 0px;
            height: auto;
            width: 30%;
            background-color: #FFF;
            border-bottom: 1px solid #0078d4;
            padding: 10px 0px;
            justify-content: center;
        }

        /* CSS para ocultar las secciones y darles estilo */
        .section {
            display: none;
            padding: 10px 0px;
            width: 90%;
            margin: 0px 5% 10px;
        }

        .section-title {
            cursor: pointer;
            margin-bottom: 5px;
            width: 100%;
            background-color: #DDD;
            padding: 10px 0px;
            border-radius: 10px;
        }

        .section-title:hover {
            background-color: #0078d4;
            color: #FFF;
        }

        .section-title.open {
            background-color: #0078d4;
        }


        /* Estilos para el formulario popup */
        .popup {
            display: none;
            position: fixed;
            bottom: 15px;
            right: 25px;
            z-index: 9;
            border-radius: 5px;
            background: linear-gradient(90deg, purple, orange);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            min-width: 250px;
            border: 2px solid #FFF;
        }

        /* Estilos para el contenido del formulario popup */
        .popup-content {
            padding: 20px;
            color: white;
        }

        .popup-content label {
            display: block;
            margin-bottom: 10px;
        }

        .label-save {
            margin-bottom: 0px;
        }

        .popup-content input[type="text"],
        .popup-content input[type="email"],
        .popup-content input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: none;
            border-radius: 3px;
            box-sizing: border-box;
        }

        .popup-content input[type="submit"] {
            background-color: #0078d4;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .popup-content input[type="submit"]:hover {
            background-color: darkblue;
        }

        /* Estilos para el botón de cerrar */
        .close {
            color: #ffffff;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #ffffff;
            text-decoration: none;
        }
    </style>
    <script src="app.js"></script>
</head>

<body>
    <?php require_once "../save/analytics.php"; ?>
    <div class="container">
        <div class="half left">
            <div class="options">
                <a class="a" href="../">Home</a>
                <a class="a" href="../sites/<?= $type ?>/download.php">Download</a>
                <button class="a" onclick="openForm()">Publish</button>
                <button type="submit" class="btn-s" onclick="send()">Save</button>
            </div>
            <div class="wrapper">
                <h1 class="h1">Editor <span style="font-size: 11px;">(Beta)<span></h1>
                <form id="myForm" action="save.php" method="post" target="frame">
                    <h2 class="section-title" onclick="toggleSection('general')">General</h2>
                    <div class="section" id="general">

                        <label for="relatedColor">Design:</label>

                        <select name="type" onchange="window.location.href = './?<?= (isset($key_code)) ? 'key_code=' . $key_code . '&' : '' ?>type='+ this.value;">
                            <option value="1" <?= ($type == 1) ? "selected" : "" ?>>Original</option>
                            <option value="2" <?= ($type == 2) ? "selected" : "" ?>>Versión 2</option>
                            <option value="3" <?= ($type == 3) ? "selected" : "" ?>>Versión 3</option>
                        </select>

                        <label for="relatedColor">Color:</label>
                        <input type="color" id="relatedColor" name="relatedColor" value="<?php echo $data['relatedColor']; ?>">

                        <label for="language">Language:</label>
                        <input type="text" id="language" name="language" value="<?php echo $data['language']; ?>">

                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" value="<?php echo $data['title']; ?>">
                    </div>
                    <h2 class="section-title" onclick="toggleSection('nav')">Navigation</h2>
                    <div class="section" id="nav">
                        <label for="logo">URL Logo:</label>
                        <input type="text" id="logo" name="nav[logo]" value="<?php echo $data['nav']['logo']; ?>">

                        <label for="mainBtnText">Main button text:</label>
                        <input type="text" id="mainBtnText" name="nav[mainBtnText]" value="<?php echo $data['nav']['mainBtnText']; ?>">

                        <label for="mainBtnUrl">Main button URL:</label>
                        <input type="text" id="mainBtnUrl" name="nav[mainBtnUrl]" value="<?php echo $data['nav']['mainBtnUrl']; ?>">

                    </div>
                    <h2 class="section-title" onclick="toggleSection('welcome')">Welcome</h2>
                    <div class="section" id="welcome">
                        <label for="welcome">Welcome phrase:</label>
                        <input type="text" id="welcome" name="welcome" value="<?php echo $data['welcome']; ?>">

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo $data['name']; ?>">

                        <label for="lastNames">Last name:</label>
                        <input type="text" id="lastNames" name="lastNames" value="<?php echo $data['lastNames']; ?>">

                        <label for="slogan">Slogan:</label>
                        <input type="text" id="slogan" name="slogan" value="<?php echo $data['slogan']; ?>">

                        <label for="scroll">Text for "Scroll":</label>
                        <input type="text" id="scroll" name="scroll" value="<?php echo $data['scroll']; ?>">

                    </div>
                    <h2 class="section-title" onclick="toggleSection('about')">About me</h2>
                    <div class="section" id="about">
                        <label for="aboutMeSlogan">Slogan:</label>
                        <input type="text" id="aboutMeSlogan" name="aboutMe[slogan]" value="<?php echo $data['aboutMe']['slogan']; ?>">

                        <label for="aboutMeBtnText">Button text:</label>
                        <input type="text" id="aboutMeBtnText" name="aboutMe[button][text]" value="<?php echo $data['aboutMe']['button']['text']; ?>">

                        <label for="aboutMeBtnUrl">Button URL:</label>
                        <input type="text" id="aboutMeBtnUrl" name="aboutMe[button][url]" value="<?php echo $data['aboutMe']['button']['url']; ?>">

                        <label for="aboutMeText">Text about me:</label>
                        <textarea id="aboutMeText" name="aboutMe[aboutMeText]"><?php echo $data['aboutMe']['aboutMeText']; ?></textarea>

                    </div>
                    <h2 class="section-title" onclick="toggleSection('social')">Social networks</h2>
                    <div class="section" id="social">

                        <label for="socialLinks_facebook_url">Facebook URL:</label>
                        <input type="text" class="form-control" id="socialLinks_facebook_url" name="socialLinks[facebook][url]" placeholder="https://www.facebook.com/..." value="<?php echo $data['socialLinks']['facebook']['url']; ?>">


                        <label for="socialLinks_twitter_url">Twitter URL:</label>
                        <input type="text" class="form-control" id="socialLinks_twitter_url" name="socialLinks[twitter][url]" placeholder="https://twitter.com/..." value="<?php echo $data['socialLinks']['twitter']['url']; ?>">

                        <label for="socialLinks_instagram_url">Instagram URL:</label>
                        <input type="text" class="form-control" id="socialLinks_instagram_url" name="socialLinks[instagram][url]" placeholder="https://www.instagram.com/..." value="<?php echo $data['socialLinks']['instagram']['url']; ?>">

                        <label for="socialLinks_web_url">Website URL:</label>
                        <input type="text" class="form-control" id="socialLinks_web_url" name="socialLinks[web][url]" placeholder="https://www..." value="<?php echo $data['socialLinks']['web']['url']; ?>">


                    </div>
                    <h2 class="section-title" onclick="toggleSection('keyArea')">Key Areas</h2>
                    <div class="section" id="keyArea">

                        <label for="keyAreasSlogan">Slogan:</label>
                        <input type="text" id="keyAreasSlogan" name="keyAreas[slogan]" value="<?php echo $data['keyAreas']['slogan']; ?>">

                        <label for="keyAreasSummary">Summary:</label>
                        <input type="text" id="keyAreasSummary" name="keyAreas[summary]" value="<?php echo $data['keyAreas']['summary']; ?>">

                        <label for="keyAreasBtnText">Button Text:</label>
                        <input type="text" id="keyAreasBtnText" name="keyAreas[btnText]" value="<?php echo $data['keyAreas']['btnText']; ?>">

                        <label for="keyAreasBtnUrl">Url:</label>
                        <input type="text" id="keyAreasBtnUrl" name="keyAreas[btnUrl]" value="<?php echo $data['keyAreas']['btnUrl']; ?>">

                        <div id="keyAreasContainer">
                            <?php foreach ($data['keyAreas']['details'] as $index => $area) : ?>
                                <div id="keyArea_<?php echo $index; ?>">
                                    <h4>Área Clave <?php echo $index + 1; ?></h4>
                                    <label for="keyAreas<?php echo $index; ?>_title">Title:</label><br>
                                    <input type="text" name="areas[<?php echo $index; ?>][title]" id="keyAreas<?php echo $index; ?>_title" required value="<?php echo $area['title']; ?>"><br><br>

                                    <label for="keyAreas<?php echo $index; ?>_description">Description:</label><br>
                                    <textarea name="areas[<?php echo $index; ?>][description]" id="keyAreas<?php echo $index; ?>_description" required><?php echo $area['description']; ?></textarea><br>
                                    <button type="button" onclick="deleteElement('keyArea', <?php echo $index; ?>)">Delete</button><br><br>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addKeyArea()">Agregar Área Clave</button>

                    </div>
                    <h2 class="section-title" onclick="toggleSection('clients')">Clientes</h2>
                    <div class="section" id="clients">

                        <label for="clientsSlogan">Slogan:</label>
                        <input type="text" id="clientsSlogan" name="clients[slogan]" value="<?php echo $data['clients']['slogan']; ?>">

                        <label for="clientsDetails">Details:</label>
                        <input type="text" id="clientsDetails" name="clients[details]" value="<?php echo $data['clients']['details']; ?>">

                        <div id="clientsContainer">
                            <?php foreach ($data['clients']['reviews'] as $index => $review) : ?>
                                <div id="client_<?php echo $index; ?>">
                                    <h3>Review <?php echo $index + 1; ?></h3>
                                    <label for="clients_reviews_<?php echo $index; ?>_textReview">Review :</label><br>
                                    <textarea id="clients_reviews_<?php echo $index; ?>_textReview" name="clients[reviews][<?php echo $index; ?>][textReview]" rows="4" cols="50"><?php echo $review['textReview']; ?></textarea><br><br>
                                    <label for="clients_reviews_<?php echo $index; ?>_name">Name:</label><br>
                                    <input type="text" id="clients_reviews_<?php echo $index; ?>_name" name="clients[reviews][<?php echo $index; ?>][name]" value="<?php echo $review['name']; ?>"><br><br>
                                    <label for="clients_reviews_<?php echo $index; ?>_position">Position:</label><br>
                                    <input type="text" id="clients_reviews_<?php echo $index; ?>_position" name="clients[reviews][<?php echo $index; ?>][position]" value="<?php echo $review['position']; ?>"><br><br>
                                    <button type="button" onclick="deleteElement('client', <?php echo $index; ?>)">Delete</button><br><br>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addClient()">Add review</button>

                    </div>
                    <h2 class="section-title" onclick="toggleSection('action')">Call to action</h2>
                    <div class="section" id="action">
                        <label for="callToActionSlogan">Slogan:</label>
                        <input type="text" id="callToActionSlogan" name="callToAction[slogan]" value="<?php echo $data['callToAction']['slogan']; ?>">

                        <label for="callToActionDetails">Details:</label>
                        <textarea id="callToActionDetails" name="callToAction[details]"><?php echo $data['callToAction']['details']; ?></textarea>

                        <label for="callToActionButtonText">Button Text:</label>
                        <input type="text" id="callToActionButtonText" name="callToAction[buttonText]" value="<?php echo $data['callToAction']['buttonText']; ?>">

                        <label for="callToActionButtonUrl">Destination URL:</label>
                        <input type="url" id="callToActionButtonUrl" name="callToAction[buttonUrl]" value="<?php echo $data['callToAction']['buttonUrl']; ?>">

                    </div>
                    <h2 class="section-title" onclick="toggleSection('news')">News</h2>
                    <div class="section" id="news">
                        <label for="newsTitle">Section Title:</label>
                        <input type="text" id="newsTitle" name="news[title]" value="<?php echo $data['news']['title']; ?>"><br><br>

                        <div id="newsContainer">
                            <?php foreach ($data['news']['articles'] as $index => $article) : ?>
                                <div id="news_<?php echo $index; ?>">
                                    <h3>New <?php echo $index + 1; ?></h3>
                                    <label for="news_<?php echo $index; ?>_type">Type:</label><br>
                                    <input type="text" id="news_<?php echo $index; ?>_type" name="articles[<?php echo $index; ?>][type]" value="<?php echo $article['type']; ?>"><br><br>
                                    <label for="news_<?php echo $index; ?>_title">Title:</label><br>
                                    <input type="text" id="news_<?php echo $index; ?>_title" name="articles[<?php echo $index; ?>][title]" value="<?php echo $article['title']; ?>"><br><br>
                                    <label for="news_<?php echo $index; ?>_summary">Summary:</label><br>
                                    <textarea id="news_<?php echo $index; ?>_summary" name="articles[<?php echo $index; ?>][summary]" rows="4" cols="50"><?php echo $article['summary']; ?></textarea><br><br>
                                    <label for="news_<?php echo $index; ?>_url">URL:</label><br>
                                    <input type="text" id="news_<?php echo $index; ?>_url" name="articles[<?php echo $index; ?>][url]" value="<?php echo $article['url']; ?>"><br>
                                    <button type="button" onclick="deleteElement('news', <?php echo $index; ?>)">Delete</button><br><br>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addNews()">Add news</button>

                    </div>
                    <h2 class="section-title" onclick="toggleSection('footer')">Footer</h2>
                    <div class="section" id="footer">
                        <label for="footerFinalDescription">Slogan:</label>
                        <input type="text" id="footerFinalDescription" name="footer[finalDescription]" value="<?php echo $data['footer']['finalDescription']; ?>">

                        <label for="footerTitleLinks">Section Title:</label>
                        <input type="text" id="footerTitleLinks" name="footer[titleLinks]" value="<?php echo $data['footer']['titleLinks']; ?>">

                        <div id="footerLinksContainer">
                            <?php foreach ($data['footer']['links'] as $index => $link) : ?>
                                <div id="footerLink_<?php echo $index; ?>">
                                    <h3>Link <?php echo $index + 1; ?></h3>
                                    <label for="footer_links_<?php echo $index; ?>_text">Text:</label><br>
                                    <input type="text" id="footer_links_<?php echo $index; ?>_text" name="footer[links][<?php echo $index; ?>][text]" value="<?php echo $link['text']; ?>"><br><br>
                                    <label for="footer_links_<?php echo $index; ?>_url">URL:</label><br>
                                    <input type="text" id="footer_links_<?php echo $index; ?>_url" name="footer[links][<?php echo $index; ?>][url]" value="<?php echo $link['url']; ?>"><br><br>
                                    <button type="button" onclick="deleteElement('footerLink', <?php echo $index; ?>)">Delete</button><br><br>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" onclick="addLink()">Add link</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="half right">
            <iframe id="frame" name="frame" class="iframe" src="../sites/<?= $type ?>/index.php"></iframe>
            <script>
                function openLinksInNewTab() {
                    var iframe = document.getElementById('frame');
                    var links = iframe.contentDocument.getElementsByTagName('a');
                    for (var i = 0; i < links.length; i++) {
                        links[i].setAttribute('target', '_blank');
                    }
                }
                document.getElementById('frame').onload = openLinksInNewTab;
            </script>
        </div>
    </div>

    <div class="popup" id="saveForm">
        <div class="popup-content">
            <span class="close" onclick="closeForm()">×</span>
            <form action="../save/index.php" method="post">
                <h2>Publish on the internet<br>100% free</h2>
                <label class="label-save" for="username">Site name:</label>
                <?php if (isset($username)) : ?>
                    <label id="gfy">https://my.gfy.dog/v1/<?= $username ?></label>
                    <input type="text" id="username" name="username" required onkeyup="generateGfy(this.value)" value="<?= $username ?>"><br>
                    <input type="hidden" name="key_code" value="<?php echo $_GET['key_code']; ?>">
                    <input type="submit" value="Update">
                <?php else : ?>
                    <label id="gfy">https://my.gfy.dog/v1/</label>
                    <input type="text" id="username" name="username" required onkeyup="generateGfy(this.value)"><br>
                    <input type="hidden" name="key_code" value="">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required><br>
                    <input type="submit" value="Publish">
                <?php endif; ?>
            </form>
        </div>
    </div>

</body>

</html>