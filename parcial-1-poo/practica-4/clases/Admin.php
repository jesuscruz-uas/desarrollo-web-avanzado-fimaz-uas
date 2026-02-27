<?php
require_once 'Usuario.php';

class Admin extends Usuario {
    public function getRol() {
        return "Administrador"; // Retorna el rol de Admin
    }
}
