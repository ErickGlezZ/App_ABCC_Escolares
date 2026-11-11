
<?php

header("Content-Type: application/json; charset=UTF-8");

include_once('../backend/config/database/conexion_mysql_escuela.php');
include_once('../backend/models/alumno_model.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    try {

        // Obtener los datos enviados mediante JSON
        $cadenaJSON = file_get_contents('php://input');
        $datos = json_decode($cadenaJSON, true);

        // Validar que se recibieron los datos
        if (empty($datos) || !is_array($datos)) {
            http_response_code(400);
            echo json_encode([
                "alta" => false,
                "mensaje" => "No se recibieron datos válidos."
            ]);
            exit;
        }

        // Validar que existan todos los campos requeridos
        $campos = ['nc', 'nombre', 'primerAp', 'segundoAp', 'fechaNac', 'semestre', 'carrera'];

        foreach ($campos as $campo) {
            if (!isset($datos[$campo]) || $datos[$campo] === '') {
                http_response_code(400);
                echo json_encode([
                    "alta" => false,
                    "mensaje" => "Falta el campo: " . $campo
                ]);
                exit;
            }
        }

        // Crear el objeto Alumno
        $alumno = new Alumno(
            $datos['nc'],
            $datos['nombre'],
            $datos['primerAp'],
            $datos['segundoAp'],
            $datos['fechaNac'],
            $datos['semestre'],
            $datos['carrera']
        );

        // Obtener conexión PDO
        $con = new ConexionBDEscuela();
        $conexion = $con->getConexion();

        // Preparar consulta SQL
        $sql = "INSERT INTO alumnos
                (Num_Control, Nombre, Primer_Ap, Segundo_Ap, Fecha_Nac, Semestre, Carrera)
                VALUES
                (:nc, :nombre, :primerAp, :segundoAp, :fechaNac, :semestre, :carrera)";

        $consulta = $conexion->prepare($sql);

        // Asociar valores
        $consulta->execute([
            ':nc' => $alumno->getNc(),
            ':nombre' => $alumno->getNombre(),
            ':primerAp' => $alumno->getPrimerAp(),
            ':segundoAp' => $alumno->getSegundoAp(),
            ':fechaNac' => $alumno->getFechaNac(),
            ':semestre' => $alumno->getSemestre(),
            ':carrera' => $alumno->getCarrera()
        ]);

        http_response_code(201);

        echo json_encode([
            "alta" => true,
            "mensaje" => "Alumno registrado correctamente."
        ]);

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "alta" => false,
            "mensaje" => "Error al registrar el alumno.",
            "error" => $e->getMessage()
        ]);

    } catch (Exception $e) {

        http_response_code(500);

        echo json_encode([
            "alta" => false,
            "mensaje" => "Error interno del servidor.",
            "error" => $e->getMessage()
        ]);

    }

} else {

    http_response_code(405);

    echo json_encode([
        "alta" => false,
        "mensaje" => "Método HTTP no permitido. Utiliza POST."
    ]);
}

?>
