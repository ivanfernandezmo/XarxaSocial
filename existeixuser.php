<?php
    // Incluir el archivo de conexión a la base de datos
    require_once('connecta_db.php');

    // Asegúrate de que los datos del formulario sean recibidos
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $usuari = $_POST['username'];
        $password = $_POST['password'];

        // Consulta SQL para verificar si el usuario existe
        $sql = "SELECT * FROM usuario WHERE username = :username AND passHash = :password AND active = 1";
        $stmt = $db->prepare($sql);
        $validat = false;

        foreach($sql as $fila){
            if(password_verify($password,$fila["passHash"])){
                $validat = true;
            }
        }
        
        // Vinculamos los parámetros para evitar SQL Injection
        $stmt->bindParam(':username', $usuari, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        // Ejecutamos la consulta
        $stmt->execute();

        // Verificar si se encontró el usuario
        if ($stmt->rowCount() > 0) {
            session_start();
            $_SESSION['usuari'] = $usuari;
            $_SESSION['password'] = $password;
            header("Location: home.php");
            exit();
        } else {
            header("Location: index.php?error=usuario_no_encontrado");
            exit();
        }
    } else {
        // En caso de que no se haya enviado el formulario
        header("Location: index.php?error=formulario_incompleto");
        exit();
    }
?>
