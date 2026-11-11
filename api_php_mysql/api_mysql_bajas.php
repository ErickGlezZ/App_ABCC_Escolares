
<?php

header("Content-Type: application/json; charset=UTF-8");

include_once('../backend/config/database/conexion_mysql_escuela.php');

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    try {

        // Obtener los datos enviados mediante JSON
        $cadenaJSON = file_get_contents('php://input');
        $datos = json_decode($cadenaJSON, true);

        // Validar que se recibieron los datos
        if (empty($datos) || !is_array($datos)) {
            http_response_code(400);
            echo json_encode([
                "baja" => false,
                "mensaje" => "No se recibieron datos válidos."
            ]);
            exit;
        }

        // Validar que exista el número de control
        if (!isset($datos['nc']) || trim($datos['nc']) === '') {
            http_response_code(400);
            echo json_encode([
                "baja" => false,
                "mensaje" => "Falta el número de control del alumno."
            ]);
            exit;
        }

        // Obtener número de control
        $nc = trim($datos['nc']);

        // Obtener conexión PDO
        $con = new ConexionBDEscuela();
        $conexion = $con->getConexion();

        // Preparar consulta SQL
        $sql = "DELETE FROM alumnos
                WHERE Num_Control = :nc";

        $consulta = $conexion->prepare($sql);

        // Ejecutar consulta
        $consulta->execute([
            ':nc' => $nc
        ]);

        // Comprobar si se eliminó algún registro
        if ($consulta->rowCount() > 0) {

            http_response_code(200);

            echo json_encode([
                "baja" => true,
                "mensaje" => "Alumno eliminado correctamente."
            ]);

        } else {

            http_response_code(404);

            echo json_encode([
                "baja" => false,
                "mensaje" => "No se encontró un alumno con ese número de control."
            ]);

        }

    } catch (PDOException $e) {

        http_response_code(500);

        echo json_encode([
            "baja" => false,
            "mensaje" => "Error al eliminar el alumno.",
            "error" => $e->getMessage()
        ]);

    } catch (Exception $e) {

        http_response_code(500);

        echo json_encode([
            "baja" => false,
            "mensaje" => "Error interno del servidor.",
            "error" => $e->getMessage()
        ]);

    }

} else {

    http_response_code(405);

    echo json_encode([
        "baja" => false,
        "mensaje" => "Método HTTP no permitido. Utiliza DELETE."
    ]);

}

?>
