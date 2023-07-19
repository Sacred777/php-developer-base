<?php

require_once __DIR__ . '/autoload.php';

use \Entities\ResponseException;

if (!empty($_POST['url'])) {

    try {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $_POST['url']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new ResponseException('Error fetching content: ' . curl_error($curl));
        }

        curl_close($curl);

        $siteContent['raw_text'] = $response;
        $jsonSiteContent = json_encode($siteContent);
        $target_url = 'http://localhost/HTMLProcessor.php';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $target_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonSiteContent);

        $response = curl_exec($curl);
        $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        curl_close($curl);

        if ($response === false) {
            throw new ResponseException('cURL error: ' . curl_error($curl));
        }

        if ($httpStatus === 500) {
            throw new ResponseException($response);
            exit();
        }

        $respJson = json_decode($response, true);
        $testText = $respJson['formatted_text'];
        echo $testText;

    } catch (ResponseException $e) {
        echo '<p style="color: red;">' . $e->getMessage() . '</p>';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Get the site page code</title>
</head>
<body>
<div class="container p-5">
    <form action="html_import_processor.php" method="post">
        <div class="mb-3">
            <label class="form-label">
                <span class="d-inline-block mb-3">Enter the address of the site page</span>
                <input class="form-control" type="text" name="url">
            </label>
        </div>
        <input class="btn btn-primary" type="submit" name="submit" value="Send">
    </form>
</div>
</body>
</html>

