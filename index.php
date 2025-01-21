<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Login</title>
    <link rel="icon" href="logos/faviconOcell.png" type="image/x-icon">
    <style>
        /* Asegura que el body ocupe todo el alto y el ancho de la pantalla */
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('imatges/mountains-1412683_1280.webp'); /* Ruta de la imagen */
            background-size: cover; /* La imagen cubre toda la pantalla */
            background-position: center; /* Centra la imagen */
            background-repeat: no-repeat; /* No repite la imagen */
            background-attachment: fixed; /* La imagen se mantiene fija al hacer scroll */
        }

        .login-image {
            width: 100%;  /* La imagen ocupará el 100% del ancho del contenedor */
            height: auto;  /* La altura será ajustada proporcionalmente */
            max-width: 200px; /* Limitar la imagen a un tamaño máximo */
            margin-bottom: 20px; /* Espacio debajo de la imagen */
            display: block;
            margin-left: auto;
            margin-right: auto; /* Centrar la imagen */
}

        .login-container {
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco semitransparente */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* Tamaño máximo */
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

        .form-input:focus {
            border-color: #66afe9;
            outline: none;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background-color:rgb(188, 73, 163);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-btn:hover {
            background-color: #0056b3;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        /* Media query para pantallas pequeñas */
        @media (max-width: 600px) {
            .login-container {
                padding: 15px;
            }

            .login-container h2 {
                font-size: 1.2em;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
    <img src="logos/sinfondo.png" alt="Imagen de inicio" class="login-image">
        <h2>Iniciar sessió</h2>
        <form action="/login" method="POST">
            <input type="text" name="username" class="form-input" placeholder="Usuari o correu electrònic" required>
            <input type="password" name="password" class="form-input" placeholder="Contrassenya" required>
            <button type="submit" class="login-btn">Iniciar sesión</button>
        </form>
        <div class="link-registre">
            <p>Encara no tens compte? <a href="register.php">Crea un compte</a></p>
        </div>
    </div>
</body>
</html>
