<?php
session_start(); // Iniciar la sesión

if (isset($_POST['guardar'])) {
    $contenido = '';
    if (isset($_SESSION['tareas'])) {
        foreach ($_SESSION['tareas'] as $fecha => $tareas) {
            $contenido = $contenido . "($fecha)\n";
            foreach ($tareas as $tarea) {
                $contenido = $contenido . "- $tarea\n";
            }
            $contenido = $contenido . "\n";
        }
    }
    $fichero = fopen('tareas.txt', 'w');
    fwrite($fichero, $contenido);
    fclose($fichero);
    echo "<p>Tareas guardadas correctamente.</br></p>";
    echo "<a href='index.php'>Volver al calendario</a>";
}
?>