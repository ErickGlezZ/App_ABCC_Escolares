<?php

    //include_once("../config/database/conexion_mysql_escuela.php");
    require_once __DIR__ . '/../config/database/conexion_mysql_escuela.php';

    $conexion = new ConexionBDEscuela();

    $con = $conexion->getConexion();

    //var_dump($con);

    class AlumnoDAO{
        private $conexion;

        public function __construct(){
            $con = new ConexionBDEscuela();
            $this->conexion = $con->getConexion();
        }


        //============ METODOS ABCC (CRUD) =================

        //------------ALTAS--------------
        public function agregarAlumno($nc, $nombre, $primerAp, $segundoAp, $fechaNac, $semestre, $carrera){

            $sql = "INSERT INTO alumnos VALUES('$nc', '$nombre', '$primerAp', '$segundoAp', '$fechaNac', '$semestre', '$carrera')";
            $res = mysqli_query($this->conexion, $sql);

            return $res;
        }

        //-------------BAJAS--------------
        public function eliminarAlumno($nc){

            $sql = "DELETE FROM alumnos WHERE Num_Control = '$nc'";
            $res = mysqli_query($this->conexion, $sql);

            return $res;
        }

        //------------ CAMBIOS -------------
        public function editarAlumno($nc, $nombre, $primerAp, $segundoAp,
                                    $fechaNac, $semestre, $carrera){

            $sql = "UPDATE alumnos SET Nombre = '$nombre', Primer_Ap = '$primerAp', Segundo_Ap = '$segundoAp', Fecha_Nac = '$fechaNac', 
            Semestre = '$semestre', 
            Carrera = '$carrera'
            WHERE Num_Control = '$nc'";

            $res = mysqli_query($this->conexion, $sql);

            return $res;
        }

        //--------------CONSULTAS--------------
        public function mostrarAlumnos($filtro){
            $sql = "SELECT Num_Control, Nombre, Primer_Ap, Segundo_Ap FROM Alumnos";
            return mysqli_query($this->conexion, $sql);
        }

        //------------ CONSULTAR ALUMNO-------------------
        public function consultarAlumno($nc){

            $sql = "SELECT * FROM alumnos WHERE Num_Control = '$nc'";

            $res = mysqli_query($this->conexion, $sql);

            return $res;
        }


        //------------ CONSULTA DE ALUMNOS CON FILTROS-------------------
        public function consultarAlumnos($nc, $nombre, $primerAp, $segundoAp, $fechaNac, $semestre, $carrera){

            $sql = "SELECT * FROM alumnos WHERE 1=1";
            $parametros = [];

            if($nc !== ''){
                $sql .= " AND Num_Control LIKE ?";
                $parametros[] = '%' . $nc . '%';
            }

            if($nombre !== ''){
                $sql .= " AND Nombre LIKE ?";
                $parametros[] = '%' . $nombre . '%';
            }

            if($primerAp !== ''){
                $sql .= " AND Primer_Ap LIKE ?";
                $parametros[] = '%' . $primerAp . '%';
            }

            if($segundoAp !== ''){
                $sql .= " AND Segundo_Ap LIKE ?";
                $parametros[] = '%' . $segundoAp . '%';
            }

            if($fechaNac !== ''){
                $sql .= " AND Fecha_Nac = ?";
                $parametros[] = $fechaNac;
            }

            if($semestre !== ''){
                $sql .= " AND Semestre = ?";
                $parametros[] = $semestre;
            }

            if($carrera !== ''){
                $sql .= " AND Carrera = ?";
                $parametros[] = $carrera;
            }

            $stmt = mysqli_prepare($this->conexion, $sql);
            if (!$stmt) {
                error_log('Error al preparar la consulta de alumnos: ' . mysqli_error($this->conexion));
                return false;
            }

            if ($parametros && !mysqli_stmt_execute($stmt, $parametros)) {
                error_log('Error al ejecutar la consulta de alumnos: ' . mysqli_stmt_error($stmt));
                mysqli_stmt_close($stmt);
                return false;
            }

            $resultado = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);

            return $resultado;
        }       
    }

?>