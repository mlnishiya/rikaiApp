<?php

session_start();

// Define target directory and error message
$target_dir = "uploads/";
$uploadOk = 1;
$message = "";

// Check if form is submitted
if (isset($_FILES)) {

    // Check if file is uploaded
    if (!isset($_FILES["arquivo"]["name"])) {
        $message = "Selecione uma imagem para enviar.";
        $uploadOk = 0;
    } else {

        // Check if file upload has errors (refer to PHP documentation for specific error codes)
        if ($_FILES["arquivo"]["error"] !== UPLOAD_ERR_OK) {
            $message = "Houve um erro ao enviar a imagem: " . $_FILES["arquivo"]["error"];
            $uploadOk = 0;
        }
    }

    // Check if file already exists (optional)
    // if (file_exists($target_dir . basename($_FILES["arquivo"]["name"]))) {
    //   $message = "O arquivo já existe.";
    //   $uploadOk = 0;
    // }
    // Check file size (optional)
    // if ($_FILES["arquivo"]["size"] > 500000) {
    //   $message = "O arquivo é muito grande. O tamanho máximo permitido é 500KB.";
    //   $uploadOk = 0;
    // }
    // Check allowed file types (optional)
    $check = getimagesize($_FILES["arquivo"]["tmp_name"]);
    if ($check === false) {
        $message = "Apenas arquivos de imagem são permitidos.";
        $uploadOk = 0;
    }

    // Move the uploaded file if no errors
    if ($uploadOk === 1) {
        $imagem = file_get_contents($_FILES["arquivo"]["tmp_name"]);
    }

    // Replace with your actual Google API key
    $apiKey = 'ADD_YOUR_API_KEY_HERE!';

    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro-vision:generateContent?key=' . $apiKey;

    $base64 = base64_encode($imagem);

    $data = [
        'contents' => [
            'parts' => [
                ['text' => '
                        Para que serve esse produto? Descreva detalhadamente
                         '],
                ['inlineData' => [
                        'mimeType' => 'image/jpeg',
                        'data' => $base64
                    ]
                ]
            ],
        ],
        'generationConfig' => [
            'temperature' => 0,
            'candidateCount' => 1,
            'maxOutputTokens' => 1000,
        ]
    ];

    $payload = json_encode($data);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));

// Suppress standard output for a cleaner response
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        echo "Error: " . $curlError . PHP_EOL;
    } else {
        $decodedResponse = json_decode($response, true);

        if (isset($decodedResponse['errors'])) {
            echo "API errors:\n";
            foreach ($decodedResponse['errors'] as $error) {
                echo "  - " . $error['message'] . PHP_EOL;
            }
        } else {
            // Process the generated content
            $generatedContent = $decodedResponse['candidates'][0]['content']['parts'][0]['text'];
            echo $generatedContent . PHP_EOL;
        }
    }
} else {
    echo "";
}