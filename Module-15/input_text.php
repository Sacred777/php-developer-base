<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/helpers/settings.php';
require_once __DIR__ . '/helpers/functions.php';

require_once __DIR__ . '/main.html';

use \Entities\TelegraphText;
use \Entities\FileStorage;

if (!empty($_POST['author']) && !empty($_POST['text'])) {

    /**
     * @param Throwable $exception
     * @return void
     */
    function exceptionHandler(Throwable $exception): void
    {
        displayAnswer($exception->getMessage(), 'exception');
    }

    set_exception_handler('exceptionHandler');

    $author = trim(htmlspecialchars($_POST['author']));
    $text = trim(htmlspecialchars($_POST['text']));
    $email = trim(htmlspecialchars($_POST['email']));
    $slug = 'db';

    $telegraphText = new \Entities\TelegraphText($author, $slug);
    $telegraphText->text = ['form', $text];

    $fileStorage = new \Entities\FileStorage();
    $fileStorage->create($telegraphText);

    if (!empty($email)) {
        $res = null;

        $mailSettings['to_email'] = $email;
        $fields = [
            'author' => [
                'fieldName' => 'Автор',
                'value' => $author,
            ],
            'text' => [
                'fieldName' => 'Текст',
                'value' => $text,
            ],
        ];

        if (!sendMail($fields, $mailSettings)) {
            displayAnswer('Ошибка отправки письма', 'error');

        } else {
            displayAnswer('Письмо отправлено успешно', 'ok');
        }
    }
}

/**
 * @param string $text
 * @param string $class
 * @return void
 */
function displayAnswer(string $text, string $class): void
{
    echo "<script>
            const answerElement = document.getElementById('answer');
            console.log(answerElement);
            answerElement.innerText = '$text';
            answerElement.classList.add('$class');
         </script>";
}

?>

