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
            $nc = $datos['Num_Control'];

            $sql = "DELETE FROM Alumnos WHERE num_control = '$nc'";
            $res = mysqli_query($conexion, $sql);

            $respuesta = array();
            if($res){
                $respuesta['baja'] = true;
            } else {
                $respuesta['baja'] = false;
            }    
            echo json_encode($respuesta);
        }
    }
?>