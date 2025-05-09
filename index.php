<?php
session_start(); // Iniciar la sesión
include_once 'conf/conf.php'; // Se incluye el archivo de configuración

$fechaActual = new DateTime();
$month = $fechaActual->format("m"); // numero mes
$year = $fechaActual->format("Y"); // año actual 2025

// Si se ha enviado el formulario, se actualizan los valores de mes y año
if (isset($_POST['month']) && isset($_POST['year'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];
}

$firstDayMonth = new DateTime("$year-$month-01"); // fecha del primer día
$firstDayWeek = $firstDayMonth->format("N"); // 1, 2, 3, 4, 5, 6, 0 = Domingo
$monthDays = $firstDayMonth->format("t"); // número de días del mes
$actualDay = $fechaActual->format("j"); // día de hoy
$numBlank = $firstDayWeek - 1;
$nameMonth = $firstDayMonth->format("F"); // nombre del mes

// Construyo la tabla para el calendario
$calendarRows = '';
for ($i = 1; $i <= $numBlank; $i++) {
    $calendarRows = $calendarRows . '<td></td>';
}

for ($j = 1; $j <= $monthDays; $j++) {
    $date = new DateTime("$year-$month-$j");
    $dayOfWeek = $date->format("w");
    $class = '';

    // Día actual
    if ($j == $actualDay && $month == $fechaActual->format("n") && $year == $fechaActual->format("Y")) {
        $class = 'actualDay';
    }

    // Festivos
    foreach ($holyDays as $type => $holidays) {
        if (isset($holidays[$month]) && in_array($j, $holidays[$month])) {
            $class = $holidays['style'];
            break;
        }
    }

    // Domingo
    if ($dayOfWeek == 0) {
        $class = 'freeDay';
    }

    $fecha = "$year-$month-$j"; // Formato YYYY-MM-DD
    // Si hay tareas, añadir la clase 'tarea'
    if (isset($_SESSION['tareas'][$fecha]) && count($_SESSION['tareas'][$fecha]) > 0) {
        $class .= ' tarea';
    }    

    // Generar celda
    $calendarRows = $calendarRows . "<td class='$class'><a href='tarea.php?dia=$j&mes=$month&anyo=$year'>$j</a></td>";

    // Nueva fila si es domingo
    if ($dayOfWeek == 0) {
        $calendarRows = $calendarRows . '</tr><tr>';
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
</head>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-family: Arial, sans-serif;
        font-size: 25px;
    }
    h1 {
        font-size: 50px;
        color: #333;
    }
    td {
        border: 1px solid black;
        padding: 30px;
        margin: 0;
        text-align: center;
    }
    .actualDay {
        background-color: green;
        color: white;
    }
    .freeDay {
        background-color: red;
        color: white;
    }
    .localHoliday {
        background-color: #ff9999;
        color: white;
    }
    .regionalHoliday {
        background-color: #ff6666;
        color: white;
    }
    .nationalHoliday {
        background-color: #ff3333;
        color: white;
    }
    .tarea {
        border: 3px solid orange;
    }
</style>
<body>
    <h1>Calendario <?php echo $year; ?></h1>
    <form action="" method="post">
        <label for="month">Mes:</label>
        <select name="month" id="month">
            <?php
            for ($m = 1; $m <= 12; $m++) {
                // Se selecciona el mes actual
                if ($m == $month) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                // Se asocia el número del mes con su nombre
                $nameMonthOption = new DateTime("$year-$m-01");
                echo '<option value="'. $m . '" ' . $selected . '>' . $nameMonthOption->format("F") . '</option>';
            }
            ?>
        </select>
        <label for="year">Año:</label>
        <input type="number" name="year" id="year" value="<?php echo $year; ?>"/>
        <input type="submit" value="Actualizar"/>
    </form>
    <table>
    <?php
    echo "<h2>$nameMonth</h2>";
    echo '<tr>';
    echo $calendarRows;
    ?>
    </table>
    <form action="guardar_tareas.php" method="post">
        <input type="submit" name="guardar" value="Guardar tareas en archivo">
    </form>
</body>
</html>