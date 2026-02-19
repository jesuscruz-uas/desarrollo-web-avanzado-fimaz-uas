<?php 

class Usuario {
  private $nombre; 
  private $correo; 
                                                            //Constructor 
public function __construct($nombre, $correo) {
  $this->nombre = nombre;
  $this->correo = correo;
}
                                                          //Metodos getter
public function getNombre() {
  return this->nombre; 
}

public function getCorreo(){
  return this->correo;
}

                                                        //metodo setter
public function setNombre($nombre) {
  $this->nombre = $nombre;
}

public function setCorreo($correo) { 
  this->correo = $correo; 
  }
}
