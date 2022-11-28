<?php
    session_start();
    
    if(!isset($_SESSION["session_usuario"]) && !isset($_SESSION["session_clave"])){
        header("Location: index.php");
    }
    
    session_destroy();
    header("Location: index.php");
?>