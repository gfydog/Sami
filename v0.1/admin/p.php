<?php
session_start();

// Datos de prueba para cada sección del formulario
$data = array(
    'relatedColor' => '#336699',
    'language' => 'es',
    'title' => 'Mi Sitio Web',
    'nav' => array(
        'logo' => 'https://example.com/logo.png',
        'mainBtnText' => 'Inicio',
        'mainBtnUrl' => 'https://example.com',
    ),
    'welcome' => '¡Bienvenido a mi sitio web!',
    'name' => 'Juan',
    'lastNames' => 'Pérez',
    'slogan' => 'Transformando ideas en realidad',
    'scroll' => 'Desplazarse hacia abajo para continuar',
    'aboutMe' => array(
        'slogan' => 'Conoce más sobre mí',
        'button' => array(
            'text' => 'Leer más',
            'url' => 'https://example.com/about'
        ),
        'aboutMeText' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit...',
    ),
    'socialLinks' => array(
        'facebook' => array(
            'url' => 'https://www.facebook.com/example'
        ),
        'twitter' => array(
            'url' => 'https://twitter.com/example'
        ),
        'instagram' => array(
            'url' => 'https://www.instagram.com/example'
        ),
        'web' => array(
            'url' => 'https://www.example.com'
        )
    ),
    'keyAreas' => array(
        'slogan' => 'Áreas Clave',
        'summary' => 'Resumen de áreas clave',
        'btnText' => 'Más información',
        'btnUrl' => 'https://example.com/key_areas',
        'details' => array(
            array(
                'title' => 'Servicios',
                'description' => 'Descripción de los servicios ofrecidos...'
            ),
            array(
                'title' => 'Productos',
                'description' => 'Descripción de los productos disponibles...'
            )
        )
    ),
    'clients' => array(
        'slogan' => 'Testimonios de clientes',
        'details' => 'Reseñas de nuestros clientes',
        'reviews' => array(
            array(
                'textReview' => 'Excelente servicio, lo recomiendo totalmente.',
                'name' => 'María',
                'position' => 'CEO, Empresa XYZ'
            ),
            array(
                'textReview' => 'Muy satisfecho con los resultados obtenidos.',
                'name' => 'Carlos',
                'position' => 'Director de Marketing'
            )
        )
    ),
    'callToAction' => array(
        'slogan' => '¿Listo para comenzar?',
        'details' => 'Contáctanos para obtener más información sobre nuestros servicios.',
        'buttonText' => 'Contáctanos',
        'buttonUrl' => 'https://example.com/contact'
    ),
    'news' => array(
        'title' => 'Noticias',
        'articles' => array(
            array(
                'type' => 'Artículo',
                'title' => 'Nuevas tendencias en diseño web',
                'summary' => 'Resumen del artículo sobre las últimas tendencias en diseño web...',
                'url' => 'https://example.com/article1'
            ),
            array(
                'type' => 'Noticia',
                'title' => 'Lanzamiento del nuevo producto',
                'summary' => 'Resumen de la noticia sobre el lanzamiento del nuevo producto...',
                'url' => 'https://example.com/news1'
            )
        )
    ),
    'footer' => array(
        'finalDescription' => '¡Gracias por visitar nuestro sitio web!',
        'titleLinks' => 'Enlaces útiles',
        'links' => array(
            array(
                'text' => 'Contáctanos',
                'url' => 'https://example.com/contact'
            ),
            array(
                'text' => 'Acerca de nosotros',
                'url' => 'https://example.com/about'
            )
        )
    )
);


$_SESSION['html'] = $data;
header("location: ./");
?>
