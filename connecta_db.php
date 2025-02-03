<?php
$cadena_connexio = 'mysql:dbname=xarxasocial;host=localhost:3335';
$usuari = 'root';
$passwd = '';
try
{
    //Creem una connexió persistent a BDs
    $db = new PDO($cadena_connexio, $usuari, $passwd, array(PDO::ATTR_PERSISTENT => true));
                                                    //Es manté la conexió oberta tot i sortir de l'script
}
catch (PDOException $e)
{
    echo 'Error amb la BDs: ' . $e->getMessage() . '<br>';
}