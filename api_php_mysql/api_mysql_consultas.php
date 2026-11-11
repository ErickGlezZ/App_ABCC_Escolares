
<?php

header("Content-Type: application/json; charset=UTF-8");

include_once('../backend/config/database/conexion_mysql_escuela.php');
include_once('../backend/models/alumno_model.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    try {

        // Obtener conexión PDO
        $con = new ConexionBDEscuela();
        $conexion = $con->getConexion();

        // Preparar consulta SQL
        $sql = "SELECT Num_Control, Nombre, Primer_Ap, Segundo_Ap,
                       Fecha_Nac, Semestre, Carrera
                FROM alumnos";

        $consulta = $conexion->prepare($sql);

        // Ejecutar consulta
        $consulta->execute();

        // Obtener registros
        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);

        // Crear arreglo de respuesta
        $respuesta['alumnos'] = array();

        // Recorrer los registros encontrados
        foreach ($registros as $fila) {

            // Crear objeto Alumno
            $alumno = new Alumno(
                $fila['Num_Control'],
                $fila['Nombre'],
                $fila['Primer_Ap'],
                $fila['Segundo_Ap'],
                $fila['Fecha_Nac'],
                $fila['Semestre'],
                $fila['Carrera']
            );

            // Obtener información del modelo
            $datosAlumno = array();

            $datosAlumno['nc'] = $alumno->getNc();
            $datosAlumno['nombre'] = $alumno->getNombre();
            $datosAlumno['primerAp'] = $alumno->getPrimerAp();
            $datosAlumno['segundoAp'] = $alumno->getSegundoAp();
            $datosAlumno['fechaNac'] = $alumno->getFechaNac();
            $datosAlumno['semestre'] = $alumno->getSemestre();
            $datosAlumno['carrera'] = $alumno->getCarrera();

            // Agregar alumno al arreglo
            array_push($respuesta['alumnos'], $datosAlumno);
        }

        // Comprobar si existen registros
        if (count($registros) > 0) {

            http_response_code(200);

            $respuesta['consulta'] = "Consulta exitosa";
            $respuesta['mensaje'] = "Alumnos encontrados correctamente.";

        } else {

            http_response_code(200);

            $respuesta['consulta'] = "Sin registros";
            $respuesta['mensaje'] = "No hay alumnos registrados.";

        }

        echo json_encode($respuesta);

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "consulta" => false,
            "mensaje" => "Error al consultar los alumnos.",
            "error" => $e->getMessage()
        ]);

    } catch (Exception $e) {

        http_response_code(500);

        echo json_encode([
            "consulta" => false,
            "mensaje" => "Error interno del servidor.",
            "error" => $e->getMessage()
        ]);

    }

} else {

    http_response_code(405);

    echo json_encode([
        "consulta" => false,
        "mensaje" => "Método HTTP no permitido. Utiliza GET."
    ]);

}

?>
