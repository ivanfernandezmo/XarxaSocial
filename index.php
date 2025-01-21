<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .login-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px; /* El máximo tamaño del contenedor */
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
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-btn:hover {
            background-color: #0056b3;
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
        <h2>Iniciar sesión</h2>
        <form action="/login" method="POST">
            <input type="text" name="username" class="form-input" placeholder="Usuario o correo electrónico" required>
            <input type="password" name="password" class="form-input" placeholder="Contraseña" required>
            <button type="submit" class="login-btn">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>
