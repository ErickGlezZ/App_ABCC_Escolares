<?php

    include("conexion_mysql_escuela.php");

    $conexion = new ConexionBDEscuela();

    $con = $conexion->getConexion();

    var_dump($con);

?>