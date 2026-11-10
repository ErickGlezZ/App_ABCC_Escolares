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

            $sql = "UPDATE Alumnos SET Nombre='$nombre', Primer_Ap='$primerAp', Segundo_Ap='$segundoAp', Fecha_Nac='$fechaNac', Semestre='$semestre', Carrera='$carrera' WHERE Num_Control='$nc'";
            $res = mysqli_query($conexion, $sql);

            $respuesta = array();
            if($res){
                $respuesta['cambio'] = true;
            } else {
                $respuesta['cambio'] = false;
            }    
            echo json_encode($respuesta);
        }

    }
?>