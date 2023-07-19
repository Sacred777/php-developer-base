<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input');

    if ($jsonData === false) {
        http_response_code(400);
        echo "Error reading JSON data from the request.";
        exit();
    }

    $dataArray = json_decode($jsonData, true);

    if ($dataArray === null) {
        http_response_code(400);
        echo "Error decoding JSON data.";
        exit();
    }

    if (empty($dataArray['raw_text'])) {
        http_response_code(500);
        echo "Json data is empty";
        exit();
    }

    $rawText = $dataArray['raw_text'];

    function replaceLinksCallback($matches)
    {
        return $matches[1];
    }

    $pattern = '/<a\s+[^>]*>(.*?)<\/a>/i';

    $replacedString = preg_replace_callback($pattern, 'replaceLinksCallback', $rawText);

    $formattedContent['formatted_text'] = $replacedString;
    $formattedJson = json_encode($formattedContent);
    header('Content-Type: application/json');
    echo $formattedJson;

};
