<?php
require_once('connecta_db.php');
session_start();

$_GET['email'];
$_GET['code'];

if (!empty($_GET['email'])&&!empty($_GET['code']))
{
    $sql = 'UPDATE usuario SET active = 1, activationCode = NULL, activationDate = "'.date("Y/m/d H:i:s").'" WHERE mail = "'.$_GET['email'].'" AND activationCode = "'.$_GET['code'].'"';
    $update = $db->query($sql);
    if ($update) {
        $_SESSION['validacio'] = true;
        header('Location: index.php');
    }
    else
    {
        echo 'Error amb la BDs: ' . $e->getMessage() . '<br>';
    }
    
}


?>