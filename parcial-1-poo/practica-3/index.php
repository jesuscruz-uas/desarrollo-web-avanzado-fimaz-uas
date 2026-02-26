<?php
require_once 'clases/Admin.php';
require_once 'clases/Alumno.php';

    echo "<h2>Práctica 3: Validaciones y Excepciones</h2>";

try {
    // Aqui validamos al Usuario 
    $alumno = new Alumno("Brayan", "cruzmaturano@outlook.com", "23169893");
    echo " Alumno creado: " . $alumno->getNombre() . "<br>";

    // En caso de haber un error nos dara mensaje de error 
    $adminInvalido = new Admin("Algo salio mal", "@outlook.com");

} catch (Exception $e) {
    // aqui mostramos el mensaje de error 
    echo "<p style='color:red;'><b>Error detectado:</b> " . $e->getMessage() . "</p>";
}
