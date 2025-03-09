<?php
    require_once('connecta_db.php');
    session_start();

    // si no hi ha usuari o password redirigim al login
    if (!isset($_SESSION['username']) || !isset($_SESSION['password'])) {
        header("Location: index.php");
        exit();
    }

    //AGAFAR FOTO
    $sql_nomUser = 'SELECT idUsuario FROM usuario where (username = "' . $_SESSION['username'] . '")';
    $return = $db->query($sql_nomUser);
    foreach($return as $fila){
        $id = $fila["idUsuario"];
    }
    $sql_dadesPerfil = 'SELECT imatge FROM perfil where (idUsuario = ' . $id . ')';
    $result = $db->query($sql_dadesPerfil);
    foreach($result as $row){
        $_SESSION['foto'] = $row["imatge"];
    }
    //ARREGLAR CADENA FOTO (quitar un punto)
    $foto = substr($_SESSION['foto'], 1);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <link rel="stylesheet" href="./estilosCSS/home.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="welcome-container">
    <div class="flex flex-col items-center">
        <img src="<?php echo $foto ?>" alt="Imagen de perfil" class="w-24 h-24 rounded-full border-4 border-blue-500">
    </div>
    <h1>Benvingut, <?php echo $_SESSION['username']; ?>!</h1>
    <p>Estàs autenticat correctament.</p>
    
</div>
<div class="button-container">
    <a href="./perfil/perfil.php" class="perfil-btn">Obrir el perfil</a>
    <a href="logout.php" class="logout-btn">Tancar sessió</a>
</div>


</body>
</html>
