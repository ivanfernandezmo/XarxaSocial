<?php
session_start();
require_once('connecta_db.php'); // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resetEmail'])) {
    $email = $_POST['resetEmail'];

    // Verificar si el email o username existe en la base de datos
    $stmt = $db->prepare("SELECT mail FROM usuario WHERE mail = $email");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Generar un código único para resetear la contraseña
        $token = bin2hex(random_bytes(50));
        $data = date('Y-m-d H:i:s')+'30 minutes';
        $stmt = $db->prepare("UPDATE usuario SET resetPassCode = $token, resetPassExpiry = $data WHERE email = $email");
        $stmt->bind_param("sss", $token, $email, $email);
        $stmt->execute();

        // Enviar email con el enlace para resetear la contraseña
        $resetLink = "http://localhost/XarxaSocial/XarxaSocial/resetPassword.php?token=" . $token."&email=" . $email."&data=" . $data;
        $_SESSION['resetLink'] = $resetLink;
        $_SESSION['token'] = $token;
        $_SESSION['email'] = $email;
        $_SESSION['data'] = $data;
        header('Location: mailResetPassword.php');
    } else {
        echo "No se encontró ninguna cuenta con este email.";
    }
}
?>
