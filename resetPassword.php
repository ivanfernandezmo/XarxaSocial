<?php
session_start();
require_once('connecta_db.php'); // Connexió a la BD

if (isset($_GET['code']) && isset($_GET['email'])) {
    $code = $_GET['code'];
    $email = $_GET['email'];
    $_SESSION['email'] = $email;
    $_SESSION['code'] = $code;

    // Comprovar si el token és vàlid i no ha expirat
    $stmt = $db->prepare("SELECT resetPassExpiry FROM usuario WHERE mail = ? AND resetPassCode = ?");
    $stmt->execute([$email, $code]);
    //PETA AQUÍ!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!????????????????????!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!????????????????????!?!?!?!?!?!??!!?
    $data = $stmt['resetPassExpiry'];
    $_SESSION['data'] = $stmt['resetPassExpiry'];
}

    // Si s'envia el formulari
    if ($_SESSION['data'] < time() && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        if ($password !== $confirmPassword) {
            echo "Les contrasenyes no coincideixen.";
        } elseif (strlen($password) < 6) {
            echo "La contrasenya ha de tenir almenys 6 caràcters.";
        } else {
            // Hash de la nova contrasenya
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Actualitzar la contrasenya a la BD i eliminar el token
            $stmt = $db->prepare("UPDATE usuario SET passHash = ?, resetPassCode = NULL, resetPassExpiry = NULL WHERE mail = ?");
            $stmt->execute([$hashedPassword, $email]);

            // Enviar Correu
            header("Location: ./mailing/mailCanviPassword.php");
            exit();
        }
    }

    


?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablir Contrasenya</title>
</head>
<body>
    <h2>Restablir la contrasenya</h2>
    <form method="POST">
        <label for="password">Nova contrasenya:</label>
        <input type="password" name="password" required>
        <br>
        <label for="confirmPassword">Confirmar contrasenya:</label>
        <input type="password" name="confirmPassword" required>
        <br>
        <button type="submit">Canviar contrasenya</button>
    </form>
</body>
</html>
