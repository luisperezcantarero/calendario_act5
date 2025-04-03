<?php
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