<?php
session_start();

if (isset($_GET['dia'])) {
    $day = $_GET['dia'];
} else {
    $day = '';
}
if (isset($_GET['mes'])) {
    $month = $_GET['mes'];
} else {
    $month = '';
}
if (isset($_GET['anyo'])) {
    $anyo = $_GET['anyo'];
} else {
    $anyo = '';
}

// Validar la fecha
$fechaValida = true;

if ($month < 1 || $month > 12 || $day < 1 || $anyo < 1) {
    $fechaValida = false;
} else {
    $MaxDiasPorMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
    if (($anyo % 4 == 0 && $anyo % 100 != 0) || ($anyo % 400 == 0)) {
        $MaxDiasPorMes[1] = 29;
    }
    $maxDias = $MaxDiasPorMes[$month - 1];
    if ($day > $maxDias) {
        $fechaValida = false;
    }
}

if (!$fechaValida) {
    echo "La fecha no es válida";
    exit;
}

$fecha = "$anyo-$month-$day"; // Formato YYYY-MM-DD

if (isset($_POST['nueva_tarea'])) {
    $tarea = $_POST['tarea'];
    if (empty($tarea)) {
        echo "No se ha introducido ninguna tarea";
    } else {
        $_SESSION['tareas'][$fecha][] = $tarea;
    }
}

if (isset($_SESSION['tareas'][$fecha])) {
    $tareas = $_SESSION['tareas'][$fecha]; // Obtener las tareas de la fecha
} else {
    $tareas = []; // Inicializar las tareas si no existen
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas de <?php echo "$day/$month/$anyo"; ?></title>
</head>
<body>
    <h1>Listado de tareas <?php echo "$day/$month/$anyo"; ?></h1>
    <form method="post">
        <input type="text" name="tarea" placeholder="Nueva tarea...">
        <input type="submit" name="nueva_tarea" value="Agregar Tarea">
    </form>
    <ul>
    <?php
    if (!empty($tareas)) {
        foreach ($tareas as $tarea) {
            echo "<li>$tarea</li>";
        }
    } else {
        echo "<li>No hay tareas para esta fecha</li>";
    }
    ?>
    </ul>
    <p><a href="index.php">Volver al calendario</a></p>
</body>
</html>