<?php
    session_start();

    $_SESSION = array(); //buidar sessió
    session_destroy(); //Destriur sessió
    setcookie(session_name(),"",time()-3600,"/"); //Assegurar que la cookie no existeixi
    header("Location: index.php");

?>