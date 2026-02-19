<?php
require_once `Usuario.php`; 

$miUsuario = new Usuario ("Brayan Cruz, cruzmaturano@outlook.com");

echo "<h1>Practica sobre Encapsulamiento con PHP</h1>"; 
echo "<p><strong>Nombre del usuario: </strong> " . $miUsuario->getNombre() . "</p>";
echo "<p><strong>Correo electrónico: </strong> " . $miUsuario->getCorreo() . "</p>";
?>
