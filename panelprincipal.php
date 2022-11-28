<?php
    #Levanta motor de inicio de sesion
    session_start(); 

    #Comprobar inicio de sesion y guardar datos
    if(isset($_POST["usuario"]) && isset($_POST["clave"])){
        $_SESSION["session_usuario"] = $_POST["usuario"];
        $_SESSION["session_clave"] = $_POST["clave"];  
    }

    #Control en caso de no iniciar sesion
    if(!isset($_SESSION["session_usuario"]) && !isset($_SESSION["session_clave"])){
        header("Location: index.php");
    }

    #Guardar valores para cookies
    $usuario = $_SESSION["session_usuario"];
    $clave = $_SESSION["session_clave"];

    #Cambio de idioma escogido para impresion en la pagina una vez ingresada sesión
    if(isset($_GET["leng"])){
        if($_GET["leng"] == 1 ){
            $idioma = "en";
            $titulo = "Product List";
            $archivo = fopen("categorias_en.txt", "r");
        }else{
            $idioma = "es";
            $titulo = "Lista de Productos";
            $archivo = fopen("categorias_es.txt", "r");
        }
    }else{#Inicio de sesión
        #Inicio de sesion con informacion de cookies
        if(isset($_COOKIE["cookie_idioma"])){
            $idioma = $_COOKIE["cookie_idioma"];
            if($idioma == "en"){
                $titulo = "Product List";
                $archivo = fopen("categorias_en.txt", "r");
            }else{
                $titulo = "Lista de Productos";
                $archivo = fopen("categorias_es.txt", "r");
            }
        }else{#Inicio de sesión sin cookies (1er inicio)
            $idioma = "es";
            $titulo = "Lista de Productos";
            $archivo = fopen("categorias_es.txt", "r");
        }
    }

    #Inicio de sesion después de un inicio previo
    if(isset($_COOKIE["cookie_recordar"])){  
        #Caso 2: refresca o cambia de página      
        if(empty($_POST)){
            $guardarPreferencias = $_COOKIE["cookie_recordar"];
            setcookie("cookie_usuario", $usuario, time()+3600*24); 
            setcookie("cookie_clave", $clave, time()+3600*24);
            setcookie("cookie_idioma", $idioma, time()+3600*24);
            setcookie("cookie_recordar", $guardarPreferencias, time()+3600*24);
        }else{ #Caso 1: viene de login
            $guardarPreferencias = isset($_POST["chkrecordar"])?$_COOKIE["cookie_recordar"]:"";
            #Caso 1.1: descarta las preferencias
            if($guardarPreferencias == ""){
                setcookie("cookie_recordar", "", -23);
                setcookie("cookie_usuario","", -23); 
                setcookie("cookie_clave", "", -23);
                setcookie("cookie_idioma","", -23);
                
                #Asignar idioma por defecto a panel principal después de iniciar sesión sin recordar preferencias
                $idioma = "es";
                $titulo = "Lista de Productos";
                $archivo = fopen("categorias_es.txt", "r");
            }else{#Caso 1.2: guarda las preferencias
                setcookie("cookie_usuario", $usuario, time()+3600*24); 
                setcookie("cookie_clave", $clave, time()+3600*24);
                setcookie("cookie_idioma", $idioma, time()+3600*24);
                setcookie("cookie_recordar", $guardarPreferencias, time()+3600*24);
            }
        }
    }else{ #Inicio de sesion por primera vez
        $guardarPreferencias = (isset($_POST["chkrecordar"]))?$_POST["chkrecordar"]:"";
        #Caso 1: guarda las preferencias y genera cookies por 1era vez
        if($guardarPreferencias != ""){
            setcookie("cookie_usuario", $usuario, time()+3600*24); 
            setcookie("cookie_clave", $clave, time()+3600*24);
            setcookie("cookie_idioma", $idioma, time()+3600*24);
            setcookie("cookie_recordar", $guardarPreferencias, time()+3600*24);
        }#En caso de que no guarde las preferencias no se generan cookies
    }
?>

<!DOCTYPE html>
<html lang = "en">
<head>
    <meta charset = "UTF-8">    
</head>
        <body>
            <h1>PANEL PRINCIPAL</h1>
            
            <h3>Bienvenido Usuario: <?php echo $_SESSION["session_usuario"]; ?></h3>
            <hr><br>
            <a href="panelprincipal.php?leng=0">ES(Español)</a>
            <?php echo " | "?>
            <a href="panelprincipal.php?leng=1">EN(Ingles)</a>
            <br><br>
            <a href = "cerrarsesion.php"> Cerrar Sesion </a>
            <h3></h3><hr><br>
            <h2><?php echo $titulo?></h2>
            <texarea><?php              
                while(!feof($archivo)){
                    $texto = fgets($archivo);
                    echo nl2br($texto);
                }
                fclose($archivo);
            ?> </texarea>
        </body>
</html>