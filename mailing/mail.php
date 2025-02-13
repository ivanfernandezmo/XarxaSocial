<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
$error = '';
$text = '';
$success = ''; 
// if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
//     header('Location: ./../../index.php');
//     exit();
// }

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $to_email = $_POST['email'];
    $username = $_POST['username'];

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
            $mail->Subject = 'hola';
            $mail->Body    = 'Benvingut '.$username. ' aquest es el teu link d\'activació.';
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
