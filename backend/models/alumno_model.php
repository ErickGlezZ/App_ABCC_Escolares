<?php

    class Alumno{
        
        private $id_alumno;
        private $nombre;
        private $apellido_paterno;
        private $apellido_materno;
        private $fecha_nacimiento;
        private $curp;
        private $correo_electronico;
        private $telefono;
        private $direccion;
        private $id_grupo;

        public function __construct($id_alumno, $nombre, $apellido_paterno, $apellido_materno, $fecha_nacimiento, $curp, $correo_electronico, $telefono, $direccion, $id_grupo) {
            $this->id_alumno = $id_alumno;
            $this->nombre = $nombre;
            $this->apellido_paterno = $apellido_paterno;
            $this->apellido_materno = $apellido_materno;
            $this->fecha_nacimiento = $fecha_nacimiento;
            $this->curp = $curp;
            $this->correo_electronico = $correo_electronico;
            $this->telefono = $telefono;
            $this->direccion = $direccion;
            $this->id_grupo = $id_grupo;
        }

        // Getters and Setters for each property can be added here
    }
?>