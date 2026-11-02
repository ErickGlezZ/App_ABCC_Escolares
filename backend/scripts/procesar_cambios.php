<?php
require_once __DIR__ . '/../controllers/alumno_dao.php';

$nc = $_POST['caja_num_control'];
$nombre = $_POST['caja_nombre'];
$primerAp = $_POST['caja_primer_ap'];
$segundoAp = $_POST['caja_segundo_ap'];
$fechaNac = $_POST['caja_fecha_nac'];
$semestre = $_POST['caja_semestre'];
$carrera = $_POST['caja_carrera'];

$alumnoDAO = new AlumnoDAO();

if ($alumnoDAO->editarAlumno(
    $nc,
    $nombre,
    $primerAp,
    $segundoAp,
    $fechaNac,
    $semestre,
    $carrera
)) {
    header('Location: ../../frontend/bajas_cambios.php');
    exit;
} else {
    echo "Error al actualizar los datos del alumno.";
}
?>