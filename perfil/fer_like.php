<?php
    require_once('../connecta_db.php');
    session_start();
    $_GET["idPost"];

    if (!isset($_SESSION['idUsuario'])) {
        header("Location: login.php");
        exit();
    } else {
        $idUsuario = $_SESSION['idUsuario'];
        $idPost =$_GET["idPost"];

        //Comprobar si existeix el like
        $sql = "SELECT * FROM magrada WHERE idPost = $idPost AND idUsuario = $idUsuario";
        $result = $db->query($sql);
        $row = $result->fetch(PDO::FETCH_ASSOC);

        
        if (empty($row))	//Si no existeix fem l'insert
        {
            $sql = "INSERT INTO magrada (idPost, idUsuario) VALUES ($idPost, $idUsuario)";
            $db->exec($sql);
        }
        else //si existeix fem un delete
        {
            $sql = "DELETE FROM magrada WHERE idPost = $idPost AND idUsuario = $idUsuario";
            $db->exec($sql);
        }
        
        header("Location: perfil.php");
    }
?>