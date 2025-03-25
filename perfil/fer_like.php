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

    header("Location: perfil.php");
}
?>