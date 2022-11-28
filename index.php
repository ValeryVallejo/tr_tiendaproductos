<?php

    $recordar = false;
    $usuario = "";
    $clave = "";
    $idioma = "";

    if(isset($_COOKIE["cookie_recordar"]) && $_COOKIE["cookie_recordar"]!=""){
        $recordar = true;
        $usuario = isset($_COOKIE["cookie_usuario"])?$_COOKIE["cookie_usuario"] : "";
        $clave = isset($_COOKIE["cookie_clave"])?$_COOKIE["cookie_clave"] : "";
        $_COOKIE["cookie_idioma"] = isset($_COOKIE["cookie_idioma"])?$_COOKIE["cookie_idioma"] : "";
    }   
?>


<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">    
</head>
        <body>
            <h1>LOGIN</h1>
            <form method="POST" action="panelprincipal.php">              
                <label for = "usuario"> Usuario: </label><br>
                <input type = "text" name = "usuario" value = "<?php echo $usuario; ?>" required><br>
                <label for = "clave"> Clave: </label><br>
                <input type="password" name="clave" value = "<?php echo $clave; ?>" required><br><br>                 
                <input type="checkbox" name="chkrecordar" <?php echo ($recordar)?"checked": ""; ?>>
                <label> Recordarme: </label><br><br>
                <input type="submit" value="Enviar">
        </body>
</html>