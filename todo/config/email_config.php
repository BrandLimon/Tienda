<?php
// Configuración del servidor de correo
define('SMTP_HOST', 'smtp.gmail.com'); // El servidor SMTP, por ejemplo, 'smtp.gmail.com'
define('SMTP_PORT', 587); // Puerto del servidor SMTP, típicamente 587 para TLS, 465 para SSL
define('SMTP_USERNAME', 'toradahaka@gmail.com'); // Tu dirección de correo electrónico
define('SMTP_PASSWORD', 'coronado02'); // Tu contraseña de correo electrónico

// Configuración adicional (opcional)
define('SMTP_ENCRYPTION', 'tls'); // Tipo de cifrado: 'tls' o 'ssl'
define('SMTP_FROM_EMAIL', 'toradahaka@gmail.com'); // Dirección de correo electrónico desde la que se enviarán los correos
define('SMTP_FROM_NAME', 'FerreTuls'); // Nombre del remitente

// Configuración de la cabecera 'From' y otros detalles (opcional)
define('SMTP_REPLY_TO_EMAIL', 'toradahaka@gmail.com'); // Dirección de correo electrónico para respuestas
define('SMTP_REPLY_TO_NAME', 'FerreTuls');

// Incluir PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Asegúrate de que la ruta es correcta

function sendEmail($to, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->Port = SMTP_PORT;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;

        // Remitente
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addReplyTo(SMTP_REPLY_TO_EMAIL, SMTP_REPLY_TO_NAME);

        // Destinatario
        $mail->addAddress($to);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
        return 'Correo enviado exitosamente';
    } catch (Exception $e) {
        return "El correo no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
    }
}
