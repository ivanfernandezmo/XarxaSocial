<?php require_once('connecta_db.php'); //executem la connexio

session_start();//iniciem una sessio
if(isset($_SESSION['usuari'])){
    header("Location: home.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['usuari'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!empty($email) && !empty($password)) {
        $_SESSION['username'] = $email;
        $_SESSION['password'] = $password;
        header('Location: mail.php');
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

    <style>
        /* Estilos generales */
        html, body {
            height: 100%;
            margin: 0;
        }

        .login-image {
            display: block;
            margin: 0 auto;
            max-width: 100%;
            height: auto;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('imatges/mountains-1412683_1280.webp');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 1.5em;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: rgb(188, 73, 163);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
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

