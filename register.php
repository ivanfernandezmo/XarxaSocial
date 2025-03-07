<?php
require_once('connecta_db.php');
// use PHPMailer\PHPMailer\PHPMailer;
// require 'vendor/autoload.php';
session_start();

// Processar formulari
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    // Validar dades i processar registre
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $verifyPassword = $_POST['verifyPassword'];
    
    $sql_comprobar = 'SELECT * from usuario where username = "'.$username.'" and mail = "'.$email.'"';
    $return = $db->query($sql_comprobar);

    if($return->rowCount() > 0){
        $error = "L''usuari o mail ja estàn donats d'alta.";
    }else if($password !== $verifyPassword){
        $error = "Les contrassenyes no son iguals.";
    }else{
        // Generar codi d'activació amb SHA-256
        $randomBytes = random_bytes(32); // 32 bytes = 256 bits
        $activationCode = hash('sha256', $randomBytes);

        $sql = 'INSERT INTO usuario (mail, username, passHash, userFirstName, userLastName, creationDate, removeDate, lastSignIn, active, activationDate, activationCode)
        values("'.$email.'","'.$username.'","'.$hash.'","'.$firstName.'","'.$lastName.'","'.date("Y/m/d H:i:s").'","'.NULL.'","'.NULL.'",0,"'.date("Y/m/d H:i:s").'","'.$activationCode.'")' ;
        $insert = $db->query($sql);
        echo '<p>Files Inserides: ' . $insert->rowCount() . '</p>';
    }

    if($insert)
    {
        $_SESSION['activationCode'] = $activationCode;
        $_SESSION['email'] = $email; //$_SESSION['mail']
        $_SESSION['username'] = $username;
        header("Location: http://localhost/XarxaSocial/mailing/mail.php");
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="icon" href="logos/faviconOcell.png" type="image/x-icon">
    <link rel="stylesheet" href="./estilosCSS/register.css">
</head>
<body>

    
    <div class="form-container">
        <div class="register-container">
            <h2>Crea un compte</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php elseif (!empty($success)): ?>
                <p class="success"><?php echo $success; ?></p>
            <?php endif; ?>
            <form action="register.php" method="POST">
                <input type="text" name="username" class="form-input" placeholder="Nom d'usuari" required>
                <input type="email" name="email" class="form-input" placeholder="Email" required>
                <input type="text" name="firstName" class="form-input" placeholder="Nom">
                <input type="text" name="lastName" class="form-input" placeholder="Cognom">
                <input type="password" name="password" class="form-input" placeholder="Contrassenya" required>
                <input type="password" name="verifyPassword" class="form-input" placeholder="Torna a introduir contrassenya" required>
                <button type="submit" class="register-btn">Registrar</button>
            </form>
            <div class="login-link">
                <p>Ja tens un compte? <a href="index.php">Inicia sessió</a></p>
            </div>
        </div>
    </div>

    
    <div class="image-container"></div>

</body>
</html>

