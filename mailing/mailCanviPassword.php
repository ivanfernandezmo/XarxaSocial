<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
require_once('../connecta_db.php');
$error = '';
$text = '';
$success = ''; 

if (isset($_SESSION['email'])) {
    $to_email = $_SESSION['email'];

    $body = '<h1>Contrasenya actualitzada</h1>
    <img src="cid:logoArcticTern" alt="Logo Arctic Tern" width="100" height="100">
    <p>La teva contrasenya s\'ha actualitzat correctament.</p>
    <p>Si no has estat tu, contacta amb suport.</p>';
    if (!empty($to_email)) {
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
            $mail->addAddress($to_email);   // Correo del destinatario
            $mail->Subject = 'Constrasenya actualitzada'; 
            $mail->AddEmbeddedImage('../logos/logoLila.png', 'logoArcticTern', 'logo.png');
            $mail->IsHTML(true);
            $mail->Body = $body;
            
            $mail->send();
            $text = 'Correu enviat';
            header('Location: ../index.php');
        } catch (Exception $e) {
            $error = "Error: {$mail->ErrorInfo}";
        }
    } else {
        $error = 'Falta omplir dades.';
    }
}