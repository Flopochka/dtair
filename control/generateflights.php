<?php
function getRandomDate($start_date, $end_date) {
    $timestamp = mt_rand(strtotime($start_date), strtotime($end_date));
    return date("Y-m-d", $timestamp);
}

function getRandomTime() {
    return sprintf('%02d:%02d:%02d', rand(0, 23), rand(0, 59), rand(0, 59));
}

function calculateDurationInSeconds($time_taken) {
    // Разбиваем строку на часы и минуты, и преобразуем их в секунды
    $matches = [];
    preg_match('/(\d+)h\s*(\d+)m/', $time_taken, $matches);
    $hours = isset($matches[1]) ? (int)$matches[1] : 0;
    $minutes = isset($matches[2]) ? (int)$matches[2] : 0;
    return $hours * 3600 + $minutes * 60;
}

function calculateArrivalTime($dep_time, $time_taken) {
    // Преобразуем время отправления в секунды
    $dep_timestamp = strtotime($dep_time);
    
    // Разбиваем время, заменяем пробелы и суммируем в секундах
    $time_parts = explode(':', str_replace(' ', '', $time_taken));
    $duration_seconds = $time_parts[0] * 3600 + $time_parts[1] * 60;
    
    // Суммируем время отправления и время в пути
    $arrival_timestamp = $dep_timestamp + $duration_seconds;

    // Преобразуем время прибытия обратно в формат HH:mm:ss
    $arrival_time = date('H:i:s', $arrival_timestamp);
    
    return $arrival_time;
}

function combineRows($rows) {
    $combinedRows = [];
    $currentRow = [];
    
    foreach ($rows as $row) {
        if (empty(array_filter($row))) {
            continue;
        }

        // If currentRow is not empty, merge it with the current row
        if (!empty($currentRow)) {
            foreach ($row as $key => $value) {
                if (empty($value)) {
                    $row[$key] = $currentRow[$key];
                }
            }
        }

        // If the row is a full row, save it and clear currentRow
        if (count(array_filter($row)) == count($row)) {
            $combinedRows[] = $row;
            $currentRow = [];
        } else {
            $currentRow = $row;
        }
    }

    // Handle the case where the last row might still be incomplete
    if (!empty($currentRow)) {
        $combinedRows[] = $currentRow;
    }

    return $combinedRows;
}
// var_dump($rowData);echo"<br>";

function getFlightData($filename) {
    $rows = file($filename);
    
    // начало корректного кода сепорации строк
    $rows = array_filter($rows, function($value){
        return trim($value) !== '';
    });
    $cleanedRows = [];
    foreach ($rows as $row) {
        if (trim($row) !== '') {
            $cleanedRows[] = trim($row);
        }
    }
    $count = count($cleanedRows);
    $newRows[0] = $rows[0];
    for ($i = 1; $i < $count; $i++) {
        // Если строка не содержит полного набора данных, добавляем данные из следующей строки
        if (count(str_getcsv($cleanedRows[$i], ";")) < count(str_getcsv($rows[0], ";"))) {
            $newRows[] = $cleanedRows[$i] . $cleanedRows[$i + 1];
            $i++; // Пропускаем следующую строку, так как она уже использована
        } else {
            $newRows[] = $cleanedRows[$i];
        }
    }
    // конец корректного кода сепорации строк
    
    // Получаем заголовок из первой строки
    $header = str_getcsv($newRows[0], ";");

    // Преобразуем строки в ассоциативные массивы
    $data = [];
    foreach ($newRows as $line) {
        $lineData = str_getcsv($line, ";");
        if (count($lineData) == count($header)) {
            $data[] = array_combine($header, $lineData);
        }
    }

    $unique_airlines = [[],[]];
    $unique_stops = [];
    foreach ($data as $flight) {
        $airline = $flight['airline'];
        $ch_code = $flight['ch_code'];
        $stop = $flight['stop'];
        
        if (!in_array($airline, $unique_airlines[0])) {
            $unique_airlines[0][] = $airline;
            $unique_airlines[1][] = $ch_code;
        }
        
        // Добавляем уникальные значения 'stop'
        if (!in_array($stop, $unique_stops)) {
            $unique_stops[][] = $stop;
        }
    }

    return [$unique_airlines, $unique_stops];
}



function generateSQL($flight, $type) {
    $current_date = new DateTime();
    $current_date->modify('+1 year');
    $date = getRandomDate(date('Y-m-d'), $current_date->format('Y-m-d'));
    
    $air = array_rand($flight[0][0]);
    $airline = $flight[0][0][$air];
    $ch_code = $flight[0][1][$air];

    $num_code = rand(100, 9999);
    $dep_time = getRandomTime();
    $time_taken = getRandomTime();
    $departure_destination = rand(1, 6);
    $arrival_destination = rand(1, 6);
    while ($arrival_destination == $departure_destination) {
        $arrival_destination = rand(1, 6);
    }
    $stop = $flight[1][array_rand($flight[1])];
    $arr_time = calculateArrivalTime($dep_time, $time_taken);
    $price = 0; // Будет рассчитано позже с помощью ИИ
    return "INSERT INTO `flights` (`id`, `date`, `airline`, `ch_code`, `num_code`, `dep_time`, `departure_destination`, `time_taken`, `stop`, `arr_time`, `arrival_destination`, `price`, `type`) VALUES (NULL, '$date', '$airline', '$ch_code', '$num_code', '$dep_time', '$departure_destination', '$time_taken', '$stop', '$arr_time', '$arrival_destination', '$price', '$type');";
}

// Путь к файлам с данными
$businessFilePath = 'buisness.csv';
$economyFilePath = 'economy.csv';

// Получаем данные из файлов
$business_flights = getFlightData($businessFilePath);
$economy_flights = getFlightData($economyFilePath);
$sql_queries = [];

for ($i = 0; $i < 1000; $i++) {
    $sql_queries[] = generateSQL($business_flights, 1);
    $sql_queries[] = generateSQL($economy_flights, 2);
}

// Записываем SQL запросы в файл
file_put_contents('flights.sql', implode("\n", $sql_queries));
include_once "../handlers/db.php";
$sql = file_get_contents("flights.sql");
$con->exec($sql);
header("Location:/control");
exit;
?>