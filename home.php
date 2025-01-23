<?php
    session_start();
    if (!isset($_SESSION['usuari']) || !isset($_SESSION['password'])) {
        header("Location: index.php");
        exit();
    }

    //Donar benvinguda a l'usuari
    echo "Benvingut " . $_SESSION['usuari'];
?>  