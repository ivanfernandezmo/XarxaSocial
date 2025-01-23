<?php
    $usuari = $_POST['username'];
    $password = $_POST['password'];

    //Consulta sql de si existeix l'usuari
    $sql = "SELECT * FROM usuaris WHERE Usuari = '$usuari' AND Contrasena = '$password'";
    $result = $db->query($sql);

    if ($result->rowCount() > 0) {
        session_start();
        $_SESSION['usuari'] = $usuari;
        $_SESSION['password'] = $password;
        header("Location: home.php"); 
    } else {
        header("Location: index.php");
    }
?>