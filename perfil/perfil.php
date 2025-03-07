<?php
require_once('../connecta_db.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
else
{
    //AGAFAR NOM I COGNOM
    $sql_nomUser = 'SELECT userFirstName, userLastName FROM usuario where (username = "' . $_SESSION['username'] . '")';
    $return = $db->query($sql_nomUser);
    foreach($return as $fila){
        $_SESSION['nom'] = $fila["userFirstName"];
        $_SESSION['cognom'] = $fila["userFirstName"];
    }
    //CONTROLAR QUE nom y cognom no estan vacios


    //AGAFAR FOTO DE PERFIL (taula perfil)
    $_SESSION['foto'] = "../imatges/fotoPerfilDefault.webp";
    //AGAFAR DESCRIPCIO (taula perfil)
    $_SESSION['descripcio'] = "Apasionado por la tecnología y el diseño. 🚀 Amante del café y los viajes. ✈️";
    //AGAFAR UBICACIÓ (taula perfil)
    $_SESSION['ubicacio'] = "Barcelona, España";
    //AGAFAR EDAT (taula perfil)
    $_SESSION['edat'] = "25";
    //AGAFAR ULTIMES PUBLICACIONS (taula posts)
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen p-6">
    <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-lg">
        <!-- Imagen de perfil -->
        <div class="flex flex-col items-center">
            <img src="<?php echo $_SESSION['foto']; ?>" alt="Imagen de perfil" class="w-24 h-24 rounded-full border-4 border-blue-500">
            <h2 class="text-2xl font-bold mt-4"><?php echo $_SESSION['nom']; ?> <?php echo $_SESSION['cognom']; ?></h2>
            <p class="text-gray-600">@<?php echo $_SESSION['username']; ?></p>
        </div>

        <!-- Información del perfil -->
        <div class="mt-6 text-center">
            <p class="text-gray-700 text-sm"><strong>Ubicació:</strong> <?php echo $_SESSION['ubicacio']; ?></p>
            <p class="text-gray-700 text-sm"><strong>Edat:</strong> <?php echo $_SESSION['edat']; ?> años</p>
            <p class="mt-4 text-gray-800">"<?php echo $_SESSION['descripcio']; ?>"</p>
        </div>

        <!-- Publicaciones destacadas -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3">Publicaciones destacadas</h3>
            <div class="space-y-3">
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <p class="text-gray-800">"Hoy aprendí algo nuevo sobre desarrollo web. 💻 #CodingLife"</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                    <p class="text-gray-800">"Explorando nuevas ciudades y conociendo culturas. 🌍"</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
