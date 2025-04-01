<?php
    require_once('../connecta_db.php');
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!isset($_SESSION['idUsuario'])) {
            header("Location: login.php");
            exit();
        } 
        else 
        {
            $idUsuario = $_SESSION['idUsuario'];
            $idPost = $_POST["idPost"];
            $comentari = $_POST["text"];

            $sql_insert = "INSERT INTO comentari VALUES ($idPost, $idUsuario, NOW(), '$comentari')";
            $db->exec($sql_insert);

        }
    }
    header("Location: perfil.php");
?>