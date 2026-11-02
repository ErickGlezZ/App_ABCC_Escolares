<?php

    //PDO
    //$pdo = new PDO("mysql:host=localhost;dbname=escuela", "root", "");

    class ConexionBDEscuela {
        private $conexion;
        private $host = "localhost:3306";
        private $usuario = "Erick";
        private $password = "usuarioitsj";
        private $bd = "BD_Escuela_Web_2026";
    

    public function __construct(){
        $this->conexion = mysqli_connect($this->host, $this->usuario, $this->password, $this->bd);

        if(!$this->conexion){
            die("Error al conectar a la base de datos: " . mysqli_connect_error());
        } else {
            //echo "Conexión exitosa a la base de datos desde conexion";
        }
    }


    public function getConexion(){
        return $this->conexion;
    }

    }
?>