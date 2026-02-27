<?php
require_once 'clases/Admin.php';
require_once 'clases/Alumno.php';
require_once 'clases/Invitado.php';

$usuarios = []; // areglo para almacenar usuarios válidados

try {
    //   objetos válidos 
    $usuarios[] = new Admin("Ximena Viveros", "ximeviveros26@gmail.com");
    $usuarios[] = new Alumno("Brayan Cruz", "brayan@correo.com", "23169893");
    $usuarios[] = new Invitado("Carlos Vallarta", "carlos@islasvall.com", "FIMAZ");

    //  Registro inválido para probar excepción 
    $usuarios[] = new Admin("Error", "escritura incorrecta");

} catch (Exception $e) {
    // Mensaje de error 
    echo "<p style='color:red;'><b>Error controlado:</b> " . $e->getMessage() . "</p>";
}
?>

<h2>Lista de Usuarios </h2>
<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Nombre</th><th>Correo</th><th>Rol</th><th>Matrícula</th><th>Empresa</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u->getNombre() ?></td>
            <td><?= $u->getCorreo() ?></td>
            <td><?= $u->getRol() ?></td>
            <td><?= (method_exists($u, 'getMatricula')) ? $u->getMatricula() : "N/A" ?></td>
            <td><?= (method_exists($u, 'getEmpresa')) ? $u->getEmpresa() : "N/A" ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
