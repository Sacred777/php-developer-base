<?php

session_start();

class IncorrectFileException extends Exception
{
}

$targetDir = './images';
$errorMessage = '';

if (isset($_FILES['photo'])) {
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777);
    }

    try {
        $mask = '/\.[^\.]*$/';
        $fileName = $_FILES['photo']['name'];
        preg_match($mask, $fileName, $matches);

        if (!isset($matches[0]) || ($matches[0] !== '.png' && $matches[0] !== '.jpg')) {
            throw new IncorrectFileException('Invalid file format - ' . $fileName);
        } elseif ($_FILES['photo']['size'] > 2097152) {
            throw new IncorrectFileException('File size too large - ' . $_FILES['photo']['size']);
        } else {
            if (!isset($_SESSION['sent'])) {
                $_SESSION['sent'] = 0;
            }

            if (isset($_POST['submit'])) {
                if ($_SESSION['sent'] > 1) {
                    throw new IncorrectFileException('Exceeded the number of upload');
                } else {
                    move_uploaded_file($_FILES['photo']['tmp_name'], $targetDir . '/' . $fileName);
                    header('location: ' . $targetDir . '/' . $fileName);
                    $_SESSION['sent']++;
                }
            }
        }
    } catch (IncorrectFileException $e) {
        $errorMessage = $e->getMessage() . PHP_EOL;
    }
}
?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Загрузка фото</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
          integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
<div class="container mt-3 mb-3">
    <p style="height: 30px; color: red; vertical-align: center"><?= $errorMessage ?></p>
    <form action="/send_photo.php" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <input class="form-control-file mb-3" type="file" name="photo">
            <input class="btn btn-primary" type="submit" name="submit" value="Загрузить фото">
        </div>
    </form>
</div>

</body>
</html>
