<?php
    include_once('../backend/config/database/conexion_mysql_escuela.php');

    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $cadenaJSON = file_get_contents('php://input');

        if(!$cadenaJSON) {
            echo "No hay cadena JSON.";

        }else{
            $datos = json_decode($cadenaJSON, true);
            $nc = $datos['nc'];
            $nombre = $datos['nombre'];
            $primerAp = $datos['primerAp'];
            $segundoAp = $datos['segundoAp'];
            $fechaNac = $datos['fechaNac'];
            $semestre = $datos['semestre'];
            $carrera = $datos['carrera'];

            $sql = "INSERT INTO Alumnos VALUES ('$nc', '$nombre', '$primerAp', '$segundoAp', '$fechaNac', '$semestre', '$carrera')";
            $res = mysqli_query($conexion, $sql);

            $respuesta = array();
            if($res){
                $respuesta['alta'] = true;
            } else {
                $respuesta['alta'] = false;
            }    
            echo json_encode($respuesta);
        }
    }
?>