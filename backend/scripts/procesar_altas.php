<?php
    include('../controllers/alumno_dao.php');
    $alumnoDAO = new AlumnoDAO();

    $nc = $_POST['caja_num_control'];
    $nombre = $_POST['caja_nombre'];
    $primerAp = $_POST['caja_primer_ap'];
    $segundoAp = $_POST['caja_segundo_ap'];
    $fechaNac = $_POST['caja_fecha_nac'];
    $semestre = $_POST['caja_semestre'];
    $carrera = $_POST['caja_carrera'];

    var_dump($nc);
    var_dump($nombre);

    //obtener los demas datos

   //obtener los demas datos

    //VALIDACIONES
    /*SUPONIENDO QUE Numero de Control DEBE SER NUMERICO
        
        - Que exista la variable relacionada con el Dato.
        - No vacíos.
        - Que sean solo numeros. 

    */

    session_start();

    $nc_correcto = false;
    if(isset($nc) && !empty($nc) && is_numeric($nc)){
        $nc_correcto = true;
    }else{
        $_SESSION['error_nc'] = true;
    }

    //Nombre DEBE SER ALFABETICO

    //Crear el OBJETO de alumno

    if($nc_correcto){
        $res = $alumnoDAO->agregarAlumno($nc, $nombre, $primerAp, $segundoAp, $fechaNac, $semestre, $carrera);

        if($res){
        //header('location:../../frontend/menu_principal.php');
        $_SESSION['insercion_correcta'] = true;
        header('location:../../frontend/formulario_altas.php');
        //echo "Ya soy casi Ingenier@ inmortal";
        }else{
            //"Me dedico a las REDES";
            $_SESSION['insercion_correcta'] = false;
        }
    }else{

        $_SESSION['nc'] = $nc;
        header('location:../../frontend/formulario_altas.php');
    }

    //$res = $alumnoDAO->agregarAlumno($nc, $nombre, $primerAp, $segundoAp, $fechaNac, $semestre, $carrera);

    
        

    
?>