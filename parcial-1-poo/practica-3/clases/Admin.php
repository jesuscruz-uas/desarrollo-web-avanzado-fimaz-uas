<?php
// incluimos la clase base
require_once 'Usuario.php';

// La clase Admin hereda de Usuario
class Admin extends Usuario {
    
    // Método específico de esta clase
    public function getRol() {
        return "Administrador";
    }
}
?>
