<?php 
require_once('connecta_db.php'); //executem la connexio

session_start();//iniciem una sessio
if(isset($_SESSION['username'])){
    header("Location: home.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' || isset($_SESSION['username']) && !isset($_SESSION['password'])) {
    $email = $_SESSION['email'];
    $password = $_SESSION['password'];
    $token = $_SESSION['code'];
    if (!empty($email) && !empty($token)) {
        $_SESSION['username'] = $email;
        $_SESSION['password'] = $password;
        header('Location: home.php');
        exit();
    } else {
        $error = 'Escriu la informació:';
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="logos/faviconOcell.png" type="image/x-icon">

    <!-- Bootstrap CSS para el Pop-up -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./estilosCSS/index.css">
    
</head>
<body>

    <div class="login-container">
        <img src="logos/sinfondo.png" alt="Imagen de inicio" class="login-image">
        <h2>Iniciar sessió</h2>
        
        <!-- Mostrar errores -->
        <?php if (isset($_GET['error'])): ?>
            <p style="color:red;">
                <?= $_GET['error'] == 'usuario_no_encontrado' ? 'Registre incorrecte.' : 'Siusplau, completa tots els camps.'; ?>
            </p>
        <?php endif; ?>

        <form action="existeixuser.php" method="POST">
            <input type="text" name="username" class="form-input" placeholder="Usuari o correu electrònic" required>
            <input type="password" name="password" class="form-input" placeholder="Contrassenya" required>
            <button type="submit" class="login-btn">Iniciar sessió</button>
        </form>

        <a href="#" class="forgot-password" data-bs-toggle="modal" data-bs-target="#resetPasswordModal">
            Forgot Password?
        </a>
        
        <div class="link-registre">
            <p>Encara no tens compte? <a href="register.php">Crea un compte</a></p>
        </div>
    </div>

    <!-- Pop-up Modal para Resetear Contraseña -->
    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="resetPasswordSend.php" method="POST">
                        <label for="resetEmail">Enter your email or username:</label>
                        <input type="text" id="resetEmail" name="resetEmail" class="form-control" required>
                        <button type="submit" class="btn btn-primary mt-3">Send Reset Password Email</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

