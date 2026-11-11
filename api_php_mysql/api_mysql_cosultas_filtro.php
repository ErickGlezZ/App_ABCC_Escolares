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

            // Obtenemos los posibles filtros o los dejamos vacíos si no vienen
            $nc        = $datos['nc'] ?? '';
            $nombre    = $datos['nombre'] ?? '';
            $primerAp  = $datos['primerAp'] ?? '';
            $segundoAp = $datos['segundoAp'] ?? '';
            $fechaNac  = $datos['fechaNac'] ?? '';
            $semestre  = $datos['semestre'] ?? '';
            $carrera   = $datos['carrera'] ?? '';

            // Búsqueda flexible por cualquier campo
            $sql = "SELECT * FROM Alumnos WHERE 
                    Num_Control LIKE '%$nc%' AND 
                    Nombre LIKE '%$nombre%' AND 
                    Primer_Ap LIKE '%$primerAp%' AND 
                    Segundo_Ap LIKE '%$segundoAp%' AND 
                    Fecha_Nac LIKE '%$fechaNac%' AND 
                    Semestre LIKE '%$semestre%' AND 
                    Carrera LIKE '%$carrera%'";

            $res = mysqli_query($conexion, $sql);

            $respuesta = array();
            if($res){
                $alumnos = mysqli_fetch_all($res, MYSQLI_ASSOC);
                
                $respuesta['exito'] = true;
                $respuesta['alumnos'] = $alumnos;
            } else {
                $respuesta['exito'] = false;
                $respuesta['alumnos'] = [];
            }    

            header('Content-Type: application/json');
            echo json_encode($respuesta);
        }

    }
?>