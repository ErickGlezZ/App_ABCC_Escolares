
<?php

header("Content-Type: application/json; charset=UTF-8");

include_once('../backend/config/database/conexion_mysql_escuela.php');
include_once('../backend/models/alumno_model.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    try {

        // Obtener los posibles filtros mediante GET
        $nc        = $_GET['nc'] ?? '';
        $nombre    = $_GET['nombre'] ?? '';
        $primerAp  = $_GET['primerAp'] ?? '';
        $segundoAp = $_GET['segundoAp'] ?? '';
        $fechaNac  = $_GET['fechaNac'] ?? '';
        $semestre  = $_GET['semestre'] ?? '';
        $carrera   = $_GET['carrera'] ?? '';

        // Obtener conexión PDO
        $con = new ConexionBDEscuela();
        $conexion = $con->getConexion();

        // Preparar consulta SQL
        $sql = "SELECT Num_Control, Nombre, Primer_Ap, Segundo_Ap,
                       Fecha_Nac, Semestre, Carrera
                FROM alumnos
                WHERE Num_Control LIKE :nc
                AND Nombre LIKE :nombre
                AND Primer_Ap LIKE :primerAp
                AND Segundo_Ap LIKE :segundoAp
                AND Fecha_Nac LIKE :fechaNac
                AND Semestre LIKE :semestre
                AND Carrera LIKE :carrera";

        $consulta = $conexion->prepare($sql);

        // Asociar los filtros a la consulta
        $consulta->execute([
            ':nc' => '%' . $nc . '%',
            ':nombre' => '%' . $nombre . '%',
            ':primerAp' => '%' . $primerAp . '%',
            ':segundoAp' => '%' . $segundoAp . '%',
            ':fechaNac' => '%' . $fechaNac . '%',
            ':semestre' => '%' . $semestre . '%',
            ':carrera' => '%' . $carrera . '%'
        ]);

        // Obtener registros encontrados
        $registros = $consulta->fetchAll(PDO::FETCH_ASSOC);

        // Crear arreglo de respuesta
        $respuesta['alumnos'] = array();

        // Recorrer los registros
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

        // Comprobar resultados de la consulta
        if (count($registros) > 0) {

            http_response_code(200);

            $respuesta['exito'] = true;
            $respuesta['mensaje'] = "Consulta por filtros exitosa.";

        } else {

            http_response_code(200);

            $respuesta['exito'] = true;
            $respuesta['mensaje'] = "No se encontraron alumnos con los filtros proporcionados.";

        }

        echo json_encode($respuesta);

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "exito" => false,
            "mensaje" => "Error al consultar los alumnos.",
            "error" => $e->getMessage()
        ]);

    } catch (Exception $e) {

        http_response_code(500);

        echo json_encode([
            "exito" => false,
            "mensaje" => "Error interno del servidor.",
            "error" => $e->getMessage()
        ]);

    }

} else {

    http_response_code(405);

    echo json_encode([
        "exito" => false,
        "mensaje" => "Método HTTP no permitido. Utiliza GET."
    ]);

}

?>
