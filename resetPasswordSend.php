<?php
session_start();
require_once('connecta_db.php'); // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['resetEmail'])) {
    $email = $_POST['resetEmail'];
    // Verificar si el email existe en la base de datos y obtener el username
    $stmt = $db->prepare("SELECT username FROM usuario WHERE mail = ?");
    $stmt->bindParam(1, $email, PDO::PARAM_STR); // Utilizamos bindParam para PDO
    $stmt->execute();

    // Verificar si el email existe en la base de datos
    $stmt2 = $db->prepare("SELECT mail FROM usuario WHERE mail = ?");
    $stmt2->bindParam(1, $email, PDO::PARAM_STR); // Utilizamos bindParam para PDO
    $stmt2->execute();

    if ($stmt->rowCount() > 0) {
// Recuperar el username
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $user['username']; // Almacenamos el username

        // Generar un código único para resetear la contraseña
        $token = bin2hex(random_bytes(32)); // 32 bytes = 64 chars
        $data = date('Y-m-d H:i:s', strtotime('+30 minutes')); // Añadido 'strtotime' para sumar 30 minutos

        // Actualizar la base de datos con el token y la fecha de expiración
        $stmt = $db->prepare("UPDATE usuario SET resetPassCode = ?, resetPassExpiry = ? WHERE mail = ?");
        $stmt->bindParam(1, $token, PDO::PARAM_STR);
        $stmt->bindParam(2, $data, PDO::PARAM_STR);
        $stmt->bindParam(3, $email, PDO::PARAM_STR);
        $stmt->execute();

        $_SESSION['code'] = $token;
        $_SESSION['email'] = $email;
        $_SESSION['data'] = $data;
        $_SESSION['username'] = $username; // Guardamos el username en la sesión

        header('Location: ./mailing/mailResetPassword.php');
    } else {
        echo "No se encontró ninguna cuenta con este email.";
    }
}
?>
