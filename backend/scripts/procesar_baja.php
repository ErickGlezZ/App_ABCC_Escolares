<?php
    var_dump($_GET['nc']);
    $nc = $_GET['nc'];
    include_once('../controllers/alumno_dao.php');
    $alumnoDAO = new AlumnoDAO();

    if($alumnoDAO ->eliminarAlumno($nc)){
        header('location:../../frontend/bajas_cambios.php');
    }
?>