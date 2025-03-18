<?php
require_once('../connecta_db.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los nuevos datos del formulario
    $nuevoNom = $_POST['nombre'];
    $nuevoCognom = $_POST['cognom'];
    $nuevaUbicacio = $_POST['ubicacio'];
    $nuevaEdat = $_POST['edat'];
    $nuevaDescripcio = $_POST['descripcio'];

    // Aquí vamos a buscar la foto actual de la base de datos para usarla si no se sube una nueva
    $sql_foto_actual = 'SELECT imatge FROM perfil WHERE idUsuario = ?';
    $stmt_foto = $db->prepare($sql_foto_actual);
    $stmt_foto->execute([$_SESSION['idUsuario']]);
    $foto_actual = $stmt_foto->fetchColumn(); // Obtiene la ruta de la foto actual

    // Si no se encuentra una foto actual, asignar la foto predeterminada
    if (!$foto_actual) {
        $foto_actual = "../imatges/fotoPerfilDefault.webp";
    }

    // Actualizamos los datos del usuario (nombre y apellido)
    $sql_update = 'UPDATE usuario SET userFirstName = ?, userLastName = ? WHERE idUsuario = ?';
    $stmt = $db->prepare($sql_update);
    $stmt->execute([$nuevoNom, $nuevoCognom, $_SESSION['idUsuario']]);

    // Actualizamos los datos del perfil (ubicación, edad, descripción)
    $sql_update_perfil = 'UPDATE perfil SET ubicacio = ?, edat = ?, descripcio = ? WHERE idUsuario = ?';
    $stmt2 = $db->prepare($sql_update_perfil);
    $stmt2->execute([$nuevaUbicacio, $nuevaEdat, $nuevaDescripcio, $_SESSION['idUsuario']]);

    // Actualizamos la foto si se sube una nueva
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) 
    {
        $uploadDir = "../imatges/perfils/";
        $imageExtension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $newImageName = 'perfil_' . $_SESSION['idUsuario'] . '.' . $imageExtension;
        $newImagePath = $uploadDir . $newImageName;
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $newImagePath)) {
            $foto = $newImagePath;
        }
    } else {
        // Si no se ha subido una nueva foto, mantenemos la foto actual
        $foto = $foto_actual;  // Mantenemos la foto actual en la variable $foto
    }


    // Actualizamos la ruta de la foto en la base de datos
    $sql_update_foto = 'UPDATE perfil SET imatge = ? WHERE idUsuario = ?';
    $stmt3 = $db->prepare($sql_update_foto);
    $stmt3->execute([$foto, $_SESSION['idUsuario']]);

    // Actualizar los datos en la base de datos (nombre, apellido, etc. ya se están actualizando anteriormente)
    $sql_update_perfil = 'UPDATE perfil SET imatge = ?, ubicacio = ?, edat = ?, descripcio = ? WHERE idUsuario = ?';
    $stmt2 = $db->prepare($sql_update_perfil);
    $stmt2->execute([$foto, $nuevaUbicacio, $nuevaEdat, $nuevaDescripcio, $_SESSION['idUsuario']]);


    // Si se ha actualizado con éxito, redirigir al perfil
    header("Location: perfil.php");
    exit();
} else {
    // Obtener los datos actuales del perfil para mostrarlos en el formulario
    $sql_nomUser = 'SELECT userFirstName, userLastName, idUsuario FROM usuario where (username = "' . $_SESSION['username'] . '")';
    $return = $db->query($sql_nomUser);
    foreach($return as $fila){
        $nom = $fila["userFirstName"];
        $cognoms = $fila["userLastName"];
        $id = $fila["idUsuario"];
        $_SESSION['idUsuario'] = $id; // Guardamos el id de usuario en la sesión
    }

    $sql_dadesPerfil = 'SELECT imatge, descripcio, ubicacio, edat FROM perfil where (idUsuario = ' . $id . ')';
    $result = $db->query($sql_dadesPerfil);
    foreach($result as $row){
        $foto = $row["imatge"];
        $descripcio = $row["descripcio"];
        $ubicacio = $row["ubicacio"];
        $edat = $row["edat"];
    }

    if($foto == null) $foto = "../imatges/fotoPerfilDefault.webp";
    if($descripcio == null) $descripcio = "No hi ha cap descripcio";
    if($ubicacio == null) $ubicacio = "No hi ha cap ubicacio";
    if($edat == null) $edat = "No hi ha cap edat";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="relative min-h-screen flex justify-center items-center p-6 bg-cover bg-center" style="background-image: url('../imatges/viajes.png');">
    <!-- Capa de fondo con transparencia -->
    <div class="absolute inset-0 bg-black bg-opacity-70"></div>

    <div class="relative z-10 bg-white p-6 rounded-xl shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Editar Perfil</h2>

        <!-- Formulario de edición de perfil -->
        <form method="POST" enctype="multipart/form-data">
            <div class="space-y-4">
                <!-- Nombre y Apellido -->
                <div>
                    <label for="nombre" class="block text-gray-700">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="w-full p-2 border border-gray-300 rounded" value="<?php echo $nom; ?>" required>
                </div>

                <div>
                    <label for="cognom" class="block text-gray-700">Apellido:</label>
                    <input type="text" id="cognom" name="cognom" class="w-full p-2 border border-gray-300 rounded" value="<?php echo $cognoms; ?>" required>
                </div>

                <!-- Ubicación -->
                <div>
                    <label for="ubicacio" class="block text-gray-700">Ubicación:</label>
                    <input type="text" id="ubicacio" name="ubicacio" class="w-full p-2 border border-gray-300 rounded" value="<?php echo $ubicacio; ?>" required>
                </div>

                <!-- Edad -->
                <div>
                    <label for="edat" class="block text-gray-700">Edad:</label>
                    <input type="number" id="edat" name="edat" class="w-full p-2 border border-gray-300 rounded" value="<?php echo $edat; ?>" required>
                </div>

                <!-- Descripción -->
                <div>
                    <label for="descripcio" class="block text-gray-700">Descripción:</label>
                    <textarea id="descripcio" name="descripcio" class="w-full p-2 border border-gray-300 rounded" rows="4" required><?php echo $descripcio; ?></textarea>
                </div>

                <!-- Foto de perfil (opcional) -->
                <div>
                    <label for="foto" class="block text-gray-700">Foto de perfil:</label>
                    <input type="file" id="foto" name="foto" class="w-full p-2 border border-gray-300 rounded">
                </div>

                <!-- Botón de guardado -->
                <div class="flex justify-center mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                        Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
