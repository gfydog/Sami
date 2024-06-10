<?php
session_start();
if (!isset($_SESSION['html'])) {
    header('location: ../../#4');
}
$data = $_SESSION['html'];
?>
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title><?= $data['title'] ?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/modernizr.js"></script>
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
</head>
<body id="top">
    <div id="preloader">
        <div id="loader" class="dots-jump">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
    <header class="s-header">
        <div class="header-logo">
                <img src="<?= $data['nav']['logo'] ?>" alt="Homepage">
        </div>
        <nav class="header-nav-wrap">
            <ul class="header-nav">
                <li><a href="#about"  class="smoothscroll" title="About">About</a></li>
                <li><a href="#news"  class="smoothscroll" title="About">News</a></li>
                <li><a href="#info" class="smoothscroll" title="Services">info</a></li>
            </ul>
        </nav>
        <a class="header-menu-toggle" href="#0"><span>Menu</span></a>
    </header>
    <section class="s-hero" data-parallax="scroll" style="background-image: url(<?= $data['nav']['logo'] ?>);">
        <div class="hero-left-bar"></div>
        <div class="row hero-content">
            <div class="column large-full hero-content__text">
                <h1><?= $data['slogan'] ?></h1>
                <div class="hero-content__buttons">
                    <a href="#about" class="smoothscroll btn btn--stroke">About Us</a>
                </div>
            </div>
        </div>
        <ul class="hero-social">
            <li class="hero-social__title">Follow Us</li>
            <?php foreach ($data['socialLinks'] as $link): ?>
                <li><a href="<?= $link['url'] ?>" title=""><?= $link['text'] ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="hero-scroll">
            <a href="#about" class="scroll-link smoothscroll">Scroll For More</a>
        </div> 
    </section> 
    <section id="about" class="s-about">
        <div class="row row-y-center about-content">
            <div class="column large-half medium-full">
                <p><?= $data['aboutMe']['aboutMeText'] ?></p>
            </div>
            <div class="column large-half medium-full">
                <ul class="about-sched">
                    <?php foreach ($data['keyAreas']['details'] as $detail): ?>
                        <li>
                            <h4><?= $detail['title'] ?></h4>
                            <p><?= $detail['description'] ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul> 
            </div>
        </div> 
    </section> 
    <section id="news" class="s-events">
        <div class="row events-header">
            <div class="column">
                <h2 class="subhead"></h2>
            </div>
        </div> 
        <div class="row block-large-1-2 block-900-full events-list">
            <?php foreach ($data['news']['articles'] as $article): ?>
                <div class="column events-list__item">
                    <h3 class="display-1 events-list__item-title">
                        <a href="<?= $article['url'] ?>" title=""><?= $article['title'] ?></a>
                    </h3>
                    <p><?= $article['summary'] ?></p>
                </div> 
            <?php endforeach; ?>
        </div> 
    </section> 
    <section id="info" class="s-series">
        <div class="series-img" style="background-image: url('<?= $data['nav']['logo'] ?>');"></div>
        <div class="row row-y-center series-content">
            <div class="column large-half medium-full">
                <h2><?= $data['aboutMe']['slogan'] ?></h2>
            </div> 
            <div class="column large-half medium-full">
                <div class="series-content__buttons">
                    <a href="<?= $data['callToAction']['buttonUrl'] ?>" class="btn btn--large h-full-width"><?= $data['callToAction']['buttonText'] ?></a>
                </div>
                <div class="series-content__subscribe">
                    <ul class="series-content__subscribe-links">
                        <?php foreach ($data['socialLinks'] as $key => $link): ?>
                            <li class="ss-<?= strtolower($key) ?>"><a href="<?= $link['url'] ?>"><?= strtolower($key) ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div> 
        </div> 
    </section> 
    <section class="s-social">
        <div class="row social-content">
            <div class="column">
                <ul class="social-list">
                    <?php foreach ($data['socialLinks'] as $key => $link): ?>
                        <li class="social-list__item">
                            <a href="<?= $link['url'] ?>" title="">
                                <span class="social-list__icon social-list__icon--<?= strtolower($key) ?>"></span>
                                <span class="social-list__text"><?= $key ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div> 
    </section> 
    <footer id="footer" class="s-footer">
        <div class="row footer-top">
            <div class="column large-6 medium-5 tab-full">
                <div class="footer-logo">
                    <a class="site-footer-logo" href="index.html">
                        <img src="<?= $data['nav']['logo'] ?>" alt="Homepage">
                    </a>
                </div> 
                <p><?= $data['footer']['finalDescription'] ?></p>
            </div>
            <div class="column large-half tab-full">
                <div class="row">
                    
                    <div class="column large-6 medium-full">
                        <h4 class="h6"><?= $data['footer']['titleLinks'] ?></h4>
                        <ul class="footer-list">
                            <?php foreach ($data['footer']['links'] as $link): ?>
                                <li><a href="<?= $link['url'] ?>"><?= $link['text'] ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div> 
        <div class="row footer-bottom">
            <div class="column ss-copyright">
                <span>© Copyright Goofy Technology Group <?= date('Y') ?></span>
                <span>Design by StyleShout</span> 
            </div>
        </div> 
        <div class="ss-go-top">
            <a class="smoothscroll" title="Back to Top" href="#top">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0l8 9h-6v15h-4v-15h-6z"/></svg>
            </a>
        </div> 
    </footer> 
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/main.js"></script>
</body>
</html>