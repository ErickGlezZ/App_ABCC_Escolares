
<?php

class Alumno {

    private $nc;
    private $nombre;
    private $primerAp;
    private $segundoAp;
    private $fechaNac;
    private $semestre;
    private $carrera;

    public function __construct($nc, $nombre, $primerAp, $segundoAp, $fechaNac, $semestre, $carrera) {
        $this->nc = $nc;
        $this->nombre = $nombre;
        $this->primerAp = $primerAp;
        $this->segundoAp = $segundoAp;
        $this->fechaNac = $fechaNac;
        $this->semestre = $semestre;
        $this->carrera = $carrera;
    }

    public function getNc() {
        return $this->nc;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getPrimerAp() {
        return $this->primerAp;
    }

    public function getSegundoAp() {
        return $this->segundoAp;
    }

    public function getFechaNac() {
        return $this->fechaNac;
    }

    public function getSemestre() {
        return $this->semestre;
    }

    public function getCarrera() {
        return $this->carrera;
    }
}
?>
