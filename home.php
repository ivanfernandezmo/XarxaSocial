<<<<<<< Updated upstream
<?php
    session_start();
    if (!isset($_SESSION['usuari']) || !isset($_SESSION['password'])) {
        header("Location: index.php");
        exit();
    }

    //Donar benvinguda a l'usuari
    echo "Benvingut " . $_SESSION['usuari'];
?>  
=======
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de prueba</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 0;
            text-align: center;
        }
        main {
            padding: 20px;
        }
        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido a la Página de Prueba</h1>
</header>

<main>
    <h2>Contenido Principal</h2>
    <p>Esta es una página web simple en HTML para probar su estructura básica.</p>
    <p>Puede agregar más contenido aquí, como imágenes, enlaces, listas, etc.</p>
</main>

<footer>
    <p>&copy; 2025 Mi Página Web</p>
</footer>

</body>
</html>
>>>>>>> Stashed changes
