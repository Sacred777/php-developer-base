<?php

/**
 * @param array $fields
 * @param array $mailSettings
 * @return bool
 */
function sendMail(array $fields, array $mailSettings): bool
{
    //Create an instance; passing `true` enables exceptions
    $mail = new \PHPMailer\PHPMailer\PHPMailer();

    try {
        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = $mailSettings['host'];
        $mail->SMTPAuth = $mailSettings['smtp_auth'];
        $mail->Username = $mailSettings['userName'];
        $mail->Password = $mailSettings['password'];
        $mail->SMTPSecure = $mailSettings['smtp_secure'];
        $mail->Port = $mailSettings['port'];

        //Recipients
        $mail->setFrom($mailSettings['from_email'], $mailSettings['from_name']);
        $mail->addAddress($mailSettings['to_email']);

        //Content
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = 'Форма с сайта';

        $flag = true;
        $massage = '';

        foreach ($fields as $key => $value) {
            $massage .= (($flag = !$flag) ? '<tr>' : '<tr style="background-color: #f8f8f8;">') . "
      <td style='padding: 10px; border: #e9e9e9 1px solid;'><b>{$value['fieldName']}</b></td>
      <td style='padding: 10px; border: #e9e9e9 1px solid;'>{$value['value']}</td></tr>";
        }

        $mail->Body = "<table styel='width: 100%;'>$massage</table>>";

        if (!$mail->send()) {
            return false;
        };

        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}


