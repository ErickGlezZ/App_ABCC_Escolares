<?php

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/../controllers/alumno_dao.php';

$alumnoDAO = new AlumnoDAO();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['nc']) || !is_string($_GET['nc']) || $_GET['nc'] === '') {
        http_response_code(400);
        echo json_encode([
            'error' => 'No se recibió un número de control válido'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $resultado = $alumnoDAO->consultarAlumno($_GET['nc']);

    if (!$resultado) {
        http_response_code(500);
        echo json_encode([
            'error' => 'No fue posible consultar al alumno'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $alumno = mysqli_fetch_assoc($resultado);
    if ($alumno) {
        echo json_encode($alumno, JSON_UNESCAPED_UNICODE);
    } else {
        http_response_code(404);
        echo json_encode([
            'error' => 'No se encontró al alumno'
        ], JSON_UNESCAPED_UNICODE);
    }

    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: GET, POST');
    echo json_encode([
        'error' => 'Método de solicitud no permitido'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

//Para consultar todos los alumnos con filtros
if (isset($_POST['nc']) || isset($_POST['nombre']) ||
    isset($_POST['primer_ap']) || isset($_POST['segundo_ap']) ||
    isset($_POST['fecha_nac']) || isset($_POST['semestre']) ||
    isset($_POST['carrera'])) {

    $nc = $_POST['nc'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $primerAp = $_POST['primer_ap'] ?? '';
    $segundoAp = $_POST['segundo_ap'] ?? '';
    $fechaNac = $_POST['fecha_nac'] ?? '';
    $semestre = $_POST['semestre'] ?? '';
    $carrera = $_POST['carrera'] ?? '';

    $resultado = $alumnoDAO->consultarAlumnos(
        $nc,
        $nombre,
        $primerAp,
        $segundoAp,
        $fechaNac,
        $semestre,
        $carrera
    );

    $alumnos = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $alumnos[] = $fila;
    }

    echo json_encode($alumnos, JSON_UNESCAPED_UNICODE);

    exit;
    }
    ?>