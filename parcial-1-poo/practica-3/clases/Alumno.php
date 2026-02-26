<?php
require_once 'Usuario.php';

class Alumno extends Usuario {
    private $matricula; 

    public function __construct($nombre, $correo, $matricula) {
        // Llamamos al constructor de la clase padre (Usuario)
        parent::__construct($nombre, $correo);
        $this->matricula = $matricula;
    }

    public function getRol() {
        return "Alumno"; 
    }

    public function getMatricula() {
        return $this->matricula;
    }
}
