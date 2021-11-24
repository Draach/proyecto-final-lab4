<?php

// Import PHPMailer classes into the global namespace 
use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$host = "smtp.gmail.com";
$SMTPAuth = true;
$username = "jmisstests@gmail.com";
$password = "JMissTests9";
$SMTPSecure = "tls";
$Port = 587;
$senderAlias = 'UTN Jobs Network';

if (isset($emailsArray)) {
    try {
        foreach ($emailsArray as $email) {
            $mail = new PHPMailer(true);

            $mail->isSMTP();                      // Set mailer to use SMTP 
            $mail->Host = $host;       // Specify main and backup SMTP servers 
            $mail->SMTPAuth = $SMTPAuth;               // Enable SMTP authentication 
            $mail->Username = $username;   // SMTP username 
            $mail->Password = $password;   // SMTP password 
            $mail->SMTPSecure = $SMTPSecure;            // Enable TLS encryption, `ssl` also accepted 
            $mail->Port = $Port;                    // TCP port to connect to 

            // Sender info 
            $mail->setFrom($username, $senderAlias);

            // Set email format to HTML 
            $mail->isHTML(true);

            // Mail Subject
            $mail->Subject = 'Propuesta Laboral Eliminada';

            // Mail body content 
            $bodyContent = '<h1>Hola ' . $email . '!</h1>';
            $bodyContent .= '<p>Lamentamos avisarte que la oferta laboral a la que estabas postulado ha expirado.</p>';
            $bodyContent .= '<p>Te invitamos a que busques una nueva propuesta que coincida con tus habilidades.</p>';
            $bodyContent .= '<p>Saludos!</p>';
            $bodyContent .= '<p>Por favor, no respondas a este mensaje.</p>';
            $mail->Body    = $bodyContent;

            $mail->addAddress($email);

            // Send email 
            $mail->send();
        }
    } catch (Exception $ex) {
        $message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        return $message;
    }
}

if (isset($email)) {
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();                      // Set mailer to use SMTP 
        $mail->Host = $host;       // Specify main and backup SMTP servers 
        $mail->SMTPAuth = $SMTPAuth;               // Enable SMTP authentication 
        $mail->Username = $username;   // SMTP username 
        $mail->Password = $password;   // SMTP password 
        $mail->SMTPSecure = $SMTPSecure;            // Enable TLS encryption, `ssl` also accepted 
        $mail->Port = $Port;                    // TCP port to connect to 

        // Sender info 
        $mail->setFrom($username, $senderAlias);

        // Set email format to HTML 
        $mail->isHTML(true);

        // Mail Subject
        $mail->Subject = 'Postulacion Anulada';

        // Mail body content 
        $bodyContent = '<h1>Hola ' . $email . '!</h1>';
        $bodyContent .= '<p>Lamentamos avisarte que tu postulación activa a una propuesta laboral ha sido anulada por un administrador.</p>';
        $bodyContent .= '<p>Te invitamos a que busques una nueva propuesta que coincida con tus habilidades.</p>';
        $bodyContent .= '<p>Saludos!</p>';
        $bodyContent .= '<p>Por favor, no respondas a este mensaje.</p>';
        $mail->Body    = $bodyContent;

        $mail->addAddress($email);

        // Send email 
        $mail->send();
    } catch (Exception $ex) {
        $message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        return $message;
    }
}
