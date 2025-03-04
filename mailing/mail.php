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
    
    $codiActivacio = $_SESSION['activationCode'];

    $body = '<h1> Correu de verificació</h1>
    <p> Benvingut a Arctic Tern </p>
    <img src="cid:logoArcticTern" alt="Logo Arctic Tern" width="100" height="100">
    <p>Per poder disfrutar de la nostra xarxa social de viatges verifica el teu compte fent clic al següent botó:</p>
    <p> <a href="http://localhost/XarxaSocial/mailCheckAccount.php?code='.$codiActivacio.'&email='.$to_email.'">Activa el teu compte</a></p>
    <p>Si no has creat un compte, ignora aquest correu.</p>';
    if (!empty($to_email) && !empty($username)) {
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
            $mail->Subject = 'Mail de verificació';
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
    <style>
        
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to bottom, #ff9a8b, #ff6a88, #ff99ac, #a044ff);
            color: white;
            text-align: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        
        p {
            font-size: 1.2em;
            padding: 10px;
            border-radius: 5px;
        }

        p[style*="color: red"] {
            background-color: rgba(255, 0, 0, 0.2);
        }

        p[style*="color: green"] {
            background-color: rgba(0, 255, 0, 0.2);
        }

        
        form {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
        }

        
        button {
            background: #ff6a88;
            border: none;
            color: white;
            padding: 12px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        button:hover {
            background: #ff99ac;
            transform: scale(1.05);
        }

    </style>
</head>
<body>
    
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($text): ?>
        <p style="color: green;"><?= htmlspecialchars($text) ?></p>
    <?php endif; ?>
    <form action = "../index.php">
        <p>S'ha enviat el correu de verificació al teu mail.</p>
        <button type="submit" name="send_mail">Tornar a la pàgina principal</button>
    </form>
    
</body>
</html>
