<?php
require_once('connecta_db.php');
// Iniciar la sesión si no lo has hecho antes (opcional, dependiendo de tus necesidades)
session_start();

// Aquí puedes agregar tu lógica PHP para procesar el formulario (guardar en la base de datos, validar, etc.)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar los datos y procesar el registro
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
    $verifyPassword = $_POST['verifyPassword'];
    

    $sql = 'INSERT INTO usuario (mail, username, passHash, userFirstName, userLastName, creationDate, removeDate, lastSignIn, active)
     values("'.$email.'","'.$username.'","'.$hash.'","'.$firstName.'","'.$lastName.'","'.date("Y/m/d H:i:s").'","'.NULL.'","'.NULL.'",1)' ;
    $db->query($sql);


    // Validaciones básicas
    if (empty($username) || empty($email) || empty($password) || $password !== $verifyPassword) {
        // Mostrar errores si algún campo obligatorio está vacío o las contraseñas no coinciden
        $error = "Si us plau, completa tots els camps obligatoris.";
    } else {
        // Aquí puedes agregar el código para guardar el usuario en la base de datos.
        // Asegúrate de usar medidas de seguridad como el hash de contraseñas (password_hash()).
        $success = "Registre realitzat amb èxit. Ara pots inicar sessió.";
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
    <style>
        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            flex-direction: row;
            height: 100vh;
            
        }

        /* Contenedor de la izquierda (formulario) */
        .form-container {
            flex: 1;
            background-color: #ffffff;
            display: flex;
            justify-content: right;
            align-items: center;
            padding: 20px;
            background-color: #f4ddcb;
        }

        /* Contenedor del formulario de registro */
        .register-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #f4f4f4;
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        .form-input:focus {
            border-color: #66afe9;
            outline: none;
        }

        .register-btn {
            width: 100%;
            padding: 10px;
            background-color:rgb(188, 73, 163);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .register-btn:hover {
            background-color: #0056b3;
        }

        .login-link {
            text-align: center;
            margin-top: 10px;
        }

        .login-link a {
            color: #007bff;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .success {
            color: green;
            font-size: 14px;
        }

        /* Contenedor de la derecha (imagen) */
        .image-container {
            flex: 1;
            background-image: url('imatges/sign-post-5655110_1280.webp'); /* Ruta de la imagen */
            background-size: contain;
            background-position: left;
            background-repeat: no-repeat;
            background-color: #f4ddcb;
            height: 100vh; /* Asegura que ocupe toda la altura de la ventana */
        }

        /* En el caso de pantallas pequeñas, apilamos los elementos verticalmente */
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .form-container, .image-container {
                flex: none;
                width: 100%;
                height: 50%;
            }

            .register-container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <!-- Contenedor principal de dos columnas -->
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

    <!-- Contenedor de la derecha (imagen) -->
    <div class="image-container"></div>

</body>
</html>

