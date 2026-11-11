
<?php

header("Content-Type: application/json; charset=UTF-8");

include_once('../backend/config/database/conexion_mysql_escuela.php');
include_once('../backend/models/alumno_model.php');

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'PATCH') {

    try {

        // Obtener los datos enviados mediante JSON
        $cadenaJSON = file_get_contents('php://input');
        $datos = json_decode($cadenaJSON, true);

        // Validar que se recibieron datos válidos
        if (!is_array($datos) || json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode([
                "cambio" => false,
                "mensaje" => "No se recibieron datos JSON válidos."
            ]);
            exit;
        }

        // Validar que exista el número de control
        if (!isset($datos['nc']) || trim($datos['nc']) === '') {
            http_response_code(400);
            echo json_encode([
                "cambio" => false,
                "mensaje" => "Falta el número de control del alumno."
            ]);
            exit;
        }

        // Obtener número de control
        $nc = trim($datos['nc']);

        // Obtener conexión PDO
        $con = new ConexionBDEscuela();
        $conexion = $con->getConexion();

        // Comprobar que exista el alumno
        $sqlExiste = "SELECT Num_Control FROM alumnos WHERE Num_Control = :nc";
        $consultaExiste = $conexion->prepare($sqlExiste);
        $consultaExiste->execute([':nc' => $nc]);

        if (!$consultaExiste->fetch(PDO::FETCH_ASSOC)) {
            http_response_code(404);
            echo json_encode([
                "cambio" => false,
                "mensaje" => "No se encontró un alumno con ese número de control."
            ]);
            exit;
        }

        // MODIFICACIÓN COMPLETA (PUT)
        if ($_SERVER['REQUEST_METHOD'] == 'PUT') {

            // Validar que existan todos los campos
            $campos = ['nombre', 'primerAp', 'segundoAp', 'fechaNac', 'semestre', 'carrera'];

            foreach ($campos as $campo) {
                if (!array_key_exists($campo, $datos) || $datos[$campo] === null || $datos[$campo] === '') {
                    http_response_code(400);
                    echo json_encode([
                        "cambio" => false,
                        "mensaje" => "Falta el campo obligatorio: " . $campo
                    ]);
                    exit;
                }
            }

            // Crear objeto Alumno
            $alumno = new Alumno(
                $nc,
                $datos['nombre'],
                $datos['primerAp'],
                $datos['segundoAp'],
                $datos['fechaNac'],
                $datos['semestre'],
                $datos['carrera']
            );

            // Preparar consulta SQL
            $sql = "UPDATE alumnos SET
                    Nombre = :nombre,
                    Primer_Ap = :primerAp,
                    Segundo_Ap = :segundoAp,
                    Fecha_Nac = :fechaNac,
                    Semestre = :semestre,
                    Carrera = :carrera
                    WHERE Num_Control = :nc";

            $consulta = $conexion->prepare($sql);

            // Ejecutar modificación completa
            $consulta->execute([
                ':nc' => $alumno->getNc(),
                ':nombre' => $alumno->getNombre(),
                ':primerAp' => $alumno->getPrimerAp(),
                ':segundoAp' => $alumno->getSegundoAp(),
                ':fechaNac' => $alumno->getFechaNac(),
                ':semestre' => $alumno->getSemestre(),
                ':carrera' => $alumno->getCarrera()
            ]);

            http_response_code(200);

            echo json_encode([
                "cambio" => true,
                "mensaje" => "Alumno modificado completamente mediante PUT."
            ]);

        }

        // MODIFICACIÓN PARCIAL (PATCH)
        else {

            // Campos permitidos para modificación
            $camposPermitidos = [
                'nombre' => 'Nombre',
                'primerAp' => 'Primer_Ap',
                'segundoAp' => 'Segundo_Ap',
                'fechaNac' => 'Fecha_Nac',
                'semestre' => 'Semestre',
                'carrera' => 'Carrera'
            ];

            $actualizaciones = [];
            $valores = [':nc' => $nc];

            // Identificar los campos que se desean modificar
            foreach ($camposPermitidos as $campo => $columna) {

                if (array_key_exists($campo, $datos)) {

                    if ($datos[$campo] === null || $datos[$campo] === '') {
                        http_response_code(400);
                        echo json_encode([
                            "cambio" => false,
                            "mensaje" => "El campo " . $campo . " no puede estar vacío."
                        ]);
                        exit;
                    }

                    $actualizaciones[] = "$columna = :$campo";
                    $valores[":$campo"] = $datos[$campo];
                }
            }

            // Validar que exista al menos un campo para modificar
            if (empty($actualizaciones)) {
                http_response_code(400);
                echo json_encode([
                    "cambio" => false,
                    "mensaje" => "No se recibieron campos para modificar."
                ]);
                exit;
            }

            // Construir consulta SQL
            $sql = "UPDATE alumnos SET " . implode(', ', $actualizaciones) .
                   " WHERE Num_Control = :nc";

            $consulta = $conexion->prepare($sql);

            // Ejecutar modificación parcial
            $consulta->execute($valores);

            http_response_code(200);

            echo json_encode([
                "cambio" => true,
                "mensaje" => "Alumno modificado parcialmente mediante PATCH."
            ]);

        }

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "cambio" => false,
            "mensaje" => "Error al modificar el alumno.",
            "error" => $e->getMessage()
        ]);

    } catch (Exception $e) {

        http_response_code(500);

        echo json_encode([
            "cambio" => false,
            "mensaje" => "Error interno del servidor.",
            "error" => $e->getMessage()
        ]);

    }

} else {

    http_response_code(405);

    echo json_encode([
        "cambio" => false,
        "mensaje" => "Método HTTP no permitido. Utiliza PUT o PATCH."
    ]);

}

?>
