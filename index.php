<?php
$fechaActual = new DateTime();
$month = $fechaActual->format("m"); // numero mes = 3
$year = $fechaActual->format("Y"); // 2025
// $month = 3;
// $year = 2025;
$firstDayMonth = new DateTime("$year-$month-01"); // fecha del primer día
$firstDayWeek = $firstDayMonth->format("N"); // 1, 2, 3, 4, 5, 6, 0 = Domingo
$monthDays = $firstDayMonth->format("t"); // número de días del mes
$actualDay = $fechaActual->format("j"); // día de hoy
$numBlank = $firstDayWeek - 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario</title>
</head>
<style>
    td {
        border: 1px solid black;
        padding: 10px;
        width: 25px;
        height: 25px;
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
</style>
<body>
    <table>
    <?php
    echo '<tr>';
    for ($i = 1; $i <= $numBlank; $i++) {
        echo '<td></td>';
    }
    for ($j = 1; $j <= $monthDays; $j++) {
        $date = new DateTime("$year-$month-$j");
        $dayOfWeek = $date->format("w");
        $class = '';
        if ($j == $actualDay && $month == $fechaActual->format("n") && $year == $fechaActual->format("Y")) {
            $class = 'actualDay';
        }
        if ($dayOfWeek == 0) { // Si es domingo
            $class = 'freeDay';
        }
        echo "<td class='$class'>$j</td>";
        if ($dayOfWeek == 0) { // Si es domingo
            echo '</tr><tr>';
        }
    }
    ?>
    </table>
</body>
</html>