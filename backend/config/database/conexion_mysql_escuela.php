
<?php

class ConexionBDEscuela {

    private $host = "localhost:3306";
    private $usuario = "Erick";
    private $password = "usuarioitsj";
    private $bdname = "BD_Escuela_Web_2026";

    private $conexion;

    public function __construct() {

        try {

            $this->conexion = new PDO(
                 "mysql:host={$this->host};dbname={$this->bdname};charset=utf8mb4",
                $this->usuario,
                $this->password
            );

            $this->conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            //echo "Conexión exitosa a la base de datos.";

        } catch (PDOException $e) {

            die("Error de conexión: " . $e->getMessage());

        }
    }

    public function getConexion() {
        return $this->conexion;
    }
}
?>
