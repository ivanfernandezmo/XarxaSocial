<?php
    session_start();

    // si no hi ha usuari o password redirigim al login
    if (!isset($_SESSION['usuari']) || !isset($_SESSION['password'])) {
        header("Location: index.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-image: url('imatges/fondo.jpg'); /* Cambia el nombre de la imagen según corresponda */
            background-size: cover;
            background-position: center;
        }

        .welcome-container {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.8); /* Fondo blanco semitransparente */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        .welcome-container h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .logout-btn {
            padding: 10px 20px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background-color: #c9302c;
        }
    </style>
</head>
<body>

<div class="welcome-container">
    <h1>Benvingut, <?php echo $_SESSION['usuari']; ?>!</h1>
    <p>Estàs autenticat correctament.</p>
    
</div>
<div><a href="logout.php" class="logout-btn">Tancar sessió</a></div>

</body>
</html>
