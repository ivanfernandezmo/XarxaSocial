<?php
    session_start();

    // si no hi ha usuari o password redirigim al login
    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
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
    <link rel="stylesheet" href="./estilosCSS/home.css">
</head>
<body>

<div class="welcome-container">
    <h1>Benvingut, <?php echo $_SESSION['username']; ?>!</h1>
    <p>Estàs autenticat correctament.</p>
    
</div>
<div class="button-container">
    <a href="./perfil/perfil.php" class="perfil-btn">Obrir el perfil</a>
    <a href="logout.php" class="logout-btn">Tancar sessió</a>
</div>


</body>
</html>
