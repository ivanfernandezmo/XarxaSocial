<?php
require_once('../connecta_db.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $idUsuario = $_SESSION['idUsuario'];

    // Procesar imagen
    $foto = null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../imatges/posts/";
        $imageExtension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $newImageName = 'post_' . time() . '.' . $imageExtension;
        $newImagePath = $uploadDir . $newImageName;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $newImagePath)) {
            $foto = $newImagePath;
        }
    }


    // Insertar post en la base de datos
    $sql_insert_post = "INSERT INTO post (idUsuario, titulo, descripcion, foto, fecha_publicacion) VALUES (?, ?, ?, ?,?)";
    $stmt = $db->prepare($sql_insert_post);
    $stmt->execute([$idUsuario, $titulo, $descripcion, $foto, date("Y/m/d")]);

    header("Location: perfil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative min-h-screen flex justify-center items-center p-6 bg-cover bg-center" style="background-image: url('../imatges/viajes.png');">
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>

    <div class="relative z-10 bg-white p-6 rounded-xl shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Crear Nuevo Post</h2>

        <form method="POST" enctype="multipart/form-data">
            <div class="space-y-4">
                <!-- Título -->
                <div>
                    <label for="titulo" class="block text-gray-700">Título:</label>
                    <input type="text" id="titulo" name="titulo" class="w-full p-2 border border-gray-300 rounded" required>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcion" class="block text-gray-700">Descripción:</label>
                    <textarea id="descripcion" name="descripcion" class="w-full p-2 border border-gray-300 rounded" rows="4" required></textarea>
                </div>

                <!-- Imagen -->
                <div>
                    <label for="foto" class="block text-gray-700">Imagen:</label>
                    <input type="file" id="foto" name="foto" class="w-full p-2 border border-gray-300 rounded">
                </div>

                <!-- Botón de publicar -->
                <div class="flex justify-center mt-6">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition">
                        Publicar
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
