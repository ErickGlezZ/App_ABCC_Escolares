<?php

    $user = $_POST['caja_usuario'];
    $pass = $_POST['caja_password'];

    $user_cifrado = sha1($user);
    $pass_cifrada = sha1($pass);

    require_once __DIR__ . '/../config/database/conexion_mysql_escuela.php';

    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();

    if($conexion){

        $sql = "SELECT * FROM usuarios WHERE usuario = '$user_cifrado' AND password = '$pass_cifrada'";

        $res = mysqli_query($conexion, $sql);

        if(mysqli_num_rows($res)==1){

            session_start();
            $_SESSION['usuario_autenticado'] = true;
            $_SESSION['nombre_usuario'] = $user;
            header("Location: ../../frontend/menu_principal.php");

        }else{

            echo "No encontrado";

        }

    }


?>