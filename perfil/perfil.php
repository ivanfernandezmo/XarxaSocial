<?php
require_once('../connecta_db.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
} else {
    //AGAFAR NOM I COGNOM
    $sql_nomUser = 'SELECT userFirstName, userLastName, idUsuario FROM usuario where (username = "' . $_SESSION['username'] . '")';
    $return = $db->query($sql_nomUser);
    foreach($return as $fila){
        $nom = $fila["userFirstName"];
        $cognoms = $fila["userLastName"];
        $id = $fila["idUsuario"];
        $_SESSION['idUsuario'] = $id;
    }

    //AGAFAR FOTO DE PERFIL
    $sql_dadesPerfil = 'SELECT imatge, descripcio, ubicacio, edat FROM perfil where (idUsuario = ' . $id . ')';
    $result = $db->query($sql_dadesPerfil);
    foreach($result as $row){
        $foto = $row["imatge"];
        $descripcio = $row["descripcio"];
        $ubicacio = $row["ubicacio"];
        $edat = $row["edat"];
    }

    //CONTROLAR VARIABLES NULL
    if($foto == null){
        $foto = "../imatges/fotoPerfilDefault.webp";
    }
    if($descripcio == null){
        $descripcio = "No hi ha cap descripcio";
    }
    if($ubicacio == null){
        $ubicacio = "No hi ha cap ubicacio";
    }
    if($edat == null){
        $edat = "No hi ha cap edat";
    }


    

    // AGAFAR ULTIMES PUBLICACIONS PER QTT de LIKES
    $sql_dadesPosts = "SELECT P.idPost, P.titulo, P.descripcion, P.foto, P.fecha_publicacion, COUNT(M.idPost) AS total_likes FROM magrada M 
	            RIGHT JOIN post P ON M.idPost = P.idPost
            WHERE P.idUsuario = $id
            GROUP BY P.idPost
            ORDER BY total_likes DESC";
    $result = $db->query($sql_dadesPosts);
    
    // Inicializar el array de posts
    $posts = [];
    $i = 0;
    foreach($result as $post){
        

        $posts[$i] = ["idPost" => $post["idPost"], "titulo" => $post["titulo"], "imagen" => $post["foto"], "descripcion" => $post["descripcion"],"fecha_publicacion" => $post["fecha_publicacion"],"likes"=>$post["total_likes"]];
        $i++;
    }


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
<body class="relative min-h-screen flex justify-center items-center p-6 bg-cover bg-center" style="background-image: url('../imatges/viajes.png');">
    <!-- Capa de fondo con transparencia -->
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>

    <div class="relative z-10 bg-white p-6 rounded-xl shadow-lg w-full max-w-lg">
        <!-- IMATGE -->
        <div class="flex flex-col items-center">
            <img src="<?php echo $foto ?>" alt="Imagen de perfil" class="w-24 h-24 rounded-full border-4 border-blue-500">
            <h2 class="text-2xl font-bold mt-4"><?php echo $nom ?> <?php echo $cognoms ?></h2>
            <p class="text-gray-600">@<?php echo $_SESSION['username']; ?></p>
        </div>

        <!-- PERFIL -->
        <div class="mt-6 text-center">
            <p class="text-gray-700 text-sm"><strong>Ubicació:</strong> <?php echo $ubicacio ?></p>
            <p class="text-gray-700 text-sm"><strong>Edat:</strong> <?php echo $edat ?> años</p>
            <p class="mt-4 text-gray-800">"<?php echo $descripcio ?>"</p>
        </div>

        <!-- CONTROLAR QUE SURTIN QUAN L'USUARI ES EL PROPIETARI DEL PERFIL -->
        <div class="mt-6 flex justify-center gap-4">
            <a href="editar_perfil.php" class="bg-orange-300 text-orange-900 px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                ✏️ Editar Perfil
            </a>
            <a href="crear_post.php" class="bg-violet-300 text-violet-900 px-4 py-2 rounded-lg hover:bg-green-600 transition">
                ➕ Afegir nou Post
            </a>
        </div>

        <!-- POSTS MEJORADOS -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold mb-3">Publicaciones destacadas</h3>
            <div class="space-y-4">
                <?php
                if (!empty($posts)) {
                    foreach ($posts as $post) { ?>
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm">
                            <h4 class="text-lg font-bold"><?php echo $post['titulo']; ?></h4>
                            <img src="<?php echo $post['imagen']; ?>" alt="Imagen del post" class="w-full h-40 object-cover rounded-lg mt-2">
                            <p class="text-gray-800 mt-2"><?php echo $post['descripcion']; ?></p>
                            <div class="flex items-center justify-between mt-3">
                                <a href="fer_like.php?idPost=<?php echo $post['idPost']; ?>" class="like-btn flex items-center text-red-500 hover:text-red-700">
                                    ❤️ <span class="ml-1"><?php echo $post['likes']; ?></span> 
                                </a>
                                <p><?php echo $post['fecha_publicacion']; ?></p>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo "<p>No tienes publicaciones para mostrar.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
