<?php
class Usuario {
    // agregue protected para que Admin y Alumno puedan acceder 
    protected $nombre;
    protected $correo;

    public function __construct($nombre, $correo) {
        // Aqui validamos el formato de correo 

        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            // Lanzar excepción si es incorrecto
            
            throw new Exception("El formato del correo '$correo' no es válido.");
        }
        $this->nombre = $nombre;
        $this->correo = $correo;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getCorreo() {
        return $this->correo;
    }
}
