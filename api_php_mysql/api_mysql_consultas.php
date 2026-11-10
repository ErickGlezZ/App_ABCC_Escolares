<?php
    include_once('../backend/config/database/conexion_mysql_escuela.php');

    $con = new ConexionBDEscuela();
    $conexion = $con->getConexion();

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        $cadenaJSON = file_get_contents('php://input');

    if(!$cadenaJSON) {
            echo "No hay cadena JSON.";

        }else{

            $sql = "SELECT * FROM Alumnos";
            $res = mysqli_query($conexion, $sql);
            $respuesta['alumnos'] = array();

            if($res){

                while($fila=mysqli_fetch_assoc($res)){
                    $alumno = array();
                    $alumno['nc'] = $fila['Num_Control'];
                    $alumno['nombre'] = $fila['Nombre'];
                    $alumno['primerAp'] = $fila['Primer_Ap'];
                    $alumno['segundoAp'] = $fila['Segundo_Ap'];
                    $alumno['fechaNac'] = $fila['Fecha_Nac'];
                    $alumno['semestre'] = $fila['Semestre'];
                    $alumno['carrera'] = $fila['Carrera'];

                    array_push($respuesta['alumnos'], $alumno);
                }
                $respuesta['consulta'] = "Consulta exitosa";
            }else{
                $respuesta['consulta'] = "No hay registros";
            }
            echo json_encode($respuesta);
        }
    }
?>