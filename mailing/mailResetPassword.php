<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
require_once('../connecta_db.php');
$error = '';
$text = '';
$success = ''; 
// if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
//     header('Location: ./../../index.php');
//     exit();
// }

if (isset($_SESSION['email'])) {
    $to_email = $_SESSION['email'];
    $username = $_SESSION['username'];
    
    $codiActivacio = $_SESSION['code'];

    $body = '<h1> Petició de canvi de contrasenya</h1>
    <img src="cid:logoArcticTern" alt="Logo Arctic Tern" width="100" height="100">
    <p>Si vols canviar la teva constrasenya fes clic al següent botó:</p>
    <p> <a href="http://localhost/XarxaSocial/resetPassword.php?code='.$codiActivacio.'&email='.$to_email.'">Reinicia la contrasenya</a></p>
    <p>Si no has sol·licitat un canvi de contrasenya, ignora aquest correu.</p>';
    if (!empty($to_email)&& !empty($username)) {
        $mail = new PHPMailer(true);
        try {
            $mail->IsSMTP();               
            $mail->SMTPDebug = 0;          
            $mail->SMTPAuth = true;        
            $mail->SMTPSecure = 'tls';     
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;             
            $mail->Username   = 'ivan.fernandezm@educem.net';   // Correo de Gmail
            $mail->Password   = 'hgea vakx kxes qssd'; // Contraseña o contraseña de aplicación
            // Configuración del correo
            $mail->setFrom('ivan.fernandezm@educem.net', 'Arctic Tern');
            $mail->addAddress($to_email, $username);   // Correo del destinatario
            $mail->Subject = 'Mail de canvi de contrasenya';
            $mail->AddEmbeddedImage('../logos/logoLila.png', 'logoArcticTern', 'logo.png');
            $mail->IsHTML(true);
            $mail->Body = $body;
            
            $mail->send();
            $text = 'Correu enviat';
        } catch (Exception $e) {
            $error = "Error: {$mail->ErrorInfo}";
        }
    } else {
        $error = 'Falta omplir dades.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>INICI</title>
</head>
<body>
    <form action = "../index.php">
        <p>Hem enviat un correu amb instruccions per resetejar la teva contrassenya.</p>
        <button type="submit" name="send_mail">Tornar a la pàgina principal</button>
    </form>
    
</body>
</html>