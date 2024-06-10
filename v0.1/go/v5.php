<?php
require_once "apiKey.php";

function getModelResponse($conversationHistory)
{
    $data = array(
        "contents" => $conversationHistory,
        "generationConfig" => array(
            "temperature" => 0.9,
            "topK" => 1,
            "topP" => 1,
            "maxOutputTokens" => 30000,
        ),
        "safetySettings" => array(
            array(
                "category" => "HARM_CATEGORY_HARASSMENT",
                "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
            ),
            array(
                "category" => "HARM_CATEGORY_HATE_SPEECH",
                "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
            ),
            array(
                "category" => "HARM_CATEGORY_SEXUALLY_EXPLICIT",
                "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
            ),
            array(
                "category" => "HARM_CATEGORY_DANGEROUS_CONTENT",
                "threshold" => "BLOCK_MEDIUM_AND_ABOVE"
            )
        )
    );

    $payload = json_encode($data);

    $ch = curl_init(URL);
    curl_setopt_array($ch, array(
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        CURLOPT_RETURNTRANSFER => true
    ));

    $response = curl_exec($ch);
    curl_close($ch);

    $data = '';

    if ($response) {
        $responseData = json_decode($response);
        if (isset($responseData->candidates[0]->content)) {
            $data = $responseData->candidates[0]->content->parts[0]->text;
        } else {
            $data = 'Could not get response from AI model.';
        }
    } else {
        $data = 'Could not connect to the AI model.';
    }

    return $data;
}

// Función para formatear una cadena JSON
function formatJson($jsonString)
{
    // Elimina ciertos caracteres especiales
    $jsonString = str_replace(["\\n", "\\", "```json", "```JSON", "```"], '', $jsonString);
    $replacements = array(
        'u00e1' => 'á',
        'u00ed' => 'í',
        'u00fa' => 'ú',
        'u00f3' => 'ó',
        'u00e9' => 'é',
        'u00c1' => 'Á',
        'u00cd' => 'Í',
        'u00da' => 'Ú',
        'u00d3' => 'Ó',
        'u00c9' => 'É',
        'u00f1' => 'ñ',
        'u00d1' => 'Ñ',
        'u00bf' => '¿',
        'u00a1' => '¡'
    );
    $jsonString = str_replace(array_keys($replacements), array_values($replacements), $jsonString);

    $jsonString = preg_replace_callback('/"([^"]+)"\s*:\s*"([^"]*)"/', function ($matches) {
        $key = $matches[1];
        $value = str_replace('"', '\\"', $matches[2]);
        $value = cleanText($value);
        return '"' . $key . '": "' . $value . '"';
    }, $jsonString);

    return $jsonString;
}

function cleanText($text)
{
    $replacements = array(
        'Ã¡' => 'á',
        'Ã©' => 'é',
        'Ã­' => 'í',
        'Ã³' => 'ó',
        'Ãº' => 'ú',
        'Ã±' => 'ñ',
        'Ã' => 'Á',
        'Ã‰' => 'É',
        'Ã' => 'Í',
        'Ã“' => 'Ó',
        'Ãš' => 'Ú',
        'Ã‘' => 'Ñ',
        'Â©' => '©'
    );

    $text = str_replace(array_keys($replacements), array_values($replacements), $text);
    return $text;
}

function main()
{
    $conversationHistory = [];

    array_push($conversationHistory, array(
        "role" => "user",
        "parts" => array(
            array(
                "text" => 'Genera un JSON con valores realistas para un nuevo sitio web titulado: "' . TITLE . '" 
        
                Datos adicionales para generar los valores del JSON:
                ' . DATA . '

        La salida debe ser estrictamente un código JSON con el siguiente formato:
        {
            "type": "1",
            "relatedColor": "{{color que se relaciona con el personaje al que nos referimos}}",
            "language": "{{idioma de los valores JSON}}",
            "title": "{{título}}",
            "nav": {
                "logo": "{{URL a la Imagen Principal}}",
                "mainBtnText": "{{frase popular del personaje}}",
                "mainBtnUrl": "{{URL de la mejor referencia}}"
            },
            "welcome": "{{frase de bienvenida}}",
            "name": "{{primer nombre del personaje}}",
            "lastNames": "{{apellido del personaje}}",
            "slogan": "{{otra frase popular del personaje}}",
            "scroll": "Desplazarse",
            "aboutMe": {
                "slogan": "{{otra frase popular del personaje}}",
                "button": {"text": "Más", "url": "{{URL del sitio web}}"},
                "aboutMeText": "{{resumen breve de los datos destacados del personaje}}"
            },
            "socialLinks": {
                "facebook": {"icon": "facebook", "text": "Facebook", "url": "{{URL del perfil en Facebook}}"},
                "twitter": {"icon": "twitter", "text": "Twitter", "url": "{{URL del perfil en Twitter}}"},
                "instagram": {"icon": "instagram", "text": "Instagram", "url": "{{URL del perfil en Instagram}}"},
                "web": {"icon": "web", "text": "Sitio web oficial", "url": "{{URL del sitio web}}"}
            },
            "keyAreas": {
                "slogan": "Sus áreas clave de experiencia.",
                "summary": "{{Texto breve que presenta y motiva la lectura de las fortalezas del personaje}}",
                "details": [
                    {
                        "title": "{{Por ejemplo: Realismo mágico}}",
                        "description": "{{Por ejemplo: García Márquez fue pionero en el género literario conocido como realismo mágico, caracterizado por la incorporación de elementos mágicos o fantásticos en narrativas por lo demás realistas.}}"
                    }
                ],
                "btnText": "Más detalles",
                "btnUrl": "{{URL donde se puede obtener más información sobre las áreas destacadas del personaje}}"
            },
            "clients": {
                "slogan": "{{Por ejemplo: Ha tenido el privilegio de cautivar a lectores en todo el mundo.}}",
                "details": "{{Texto resumido.}}",
                "reviews": [
                    {
                        "textReview": "{{texto de la reseña}}",
                        "name": "{{nombre del reseñador}}",
                        "position": "{{nombre de la empresa o puesto de trabajo}}"
                    }
                ]
            },
            "callToAction": {
                "slogan": "{{Ejemplo: Comience con una consulta hoy.}}",
                "details": "{{Texto relacionado con el personaje, motivando a hacer clic en el botón Ir}}",
                "buttonText": "{{texto breve, por ejemplo: \'leer ahora\', \'Explorar ahora\'...}}",
                "buttonUrl": "{{URL del sitio web del personaje}}"
            },
            "news": {
                "title": "{{Ejemplo: Manténgase actualizado con las últimas noticias y eventos.}}",
                "articles": [
                    {
                        "type": "{{Categoría o etiqueta principal de la noticia}}",
                        "title": "{{Título del artículo}}",
                        "summary": "{{Resumen breve del artículo}}",
                        "url": "{{URL del artículo}}"
                    }
                ]
            },
            "footer": {
                "finalDescription": "{{Breve resumen general.}}",
                "titleLinks": "Enlaces útiles",
                "links": [
                    {
                        "text": "{{Por ejemplo: Inicio}}",
                        "url": "{{URL del sitio web}}"
                    }
                ]
            }
        }

        **Importante:**
        1. Estrictamente los valores en el JSON NO pueden contener comillas simples ni dobles.
        2. Estrictamente los valores de las claves en el JSON NO pueden ser nulos (null): genera texto para el valor de esa clave.
        3. Todos los valores en el JSON deben estar llenos: genera texto en caso estar vacío el valor.
        4. La salida debe ser estrictamente un código JSON con el formato especificado.'
            )
        )
    ));


    $finalResponse = getModelResponse($conversationHistory);

    $jsonString = formatJson($finalResponse);
    $data = json_decode($jsonString, true);

    if ($data == NULL) {
        $errorData = array(
            'error' => 'Error processing the response from the AI model.',
            'response' => $finalResponse
        );
        return $errorData;
    }

    return $data;
}

$data = main();
