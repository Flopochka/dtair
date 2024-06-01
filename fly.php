<?php
function getRandomDate($start_date, $end_date) {
    $timestamp = mt_rand(strtotime($start_date), strtotime($end_date));
    return date("Y-m-d", $timestamp);
}

function getRandomTime() {
    return sprintf('%02d:%02d:%02d', rand(0, 23), rand(0, 59), rand(0, 59));
}
function calculateArrivalTime($dep_time, $time_taken) {
    $dep_timestamp = strtotime($dep_time);
    $duration = calculateDurationInSeconds($time_taken); // Используем функцию calculateDurationInSeconds()
    return date('H:i:s', $dep_timestamp + $duration);
}

function calculateDurationInSeconds($time_taken) {
    // Разбиваем строку на часы и минуты, и преобразуем их в секунды
    $matches = [];
    preg_match('/(\d+)h\s*(\d+)m/', $time_taken, $matches);
    $hours = isset($matches[1]) ? (int)$matches[1] : 0;
    $minutes = isset($matches[2]) ? (int)$matches[2] : 0;
    return $hours * 3600 + $minutes * 60;
}

// function calculateArrivalTime($dep_time, $time_taken) {
//     $dep_timestamp = strtotime($dep_time);
//     $time_parts = explode(':', str_replace(' ', '', $time_taken));
//     $duration = ($time_parts[0] * 3600) + ($time_parts[1] * 60);
//     return date('H:i:s', $dep_timestamp + $duration);
// }

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
// var_dump($rowData);echo"\n";

function getFlightData($filename) {
    $rows = file($filename);
    $dataText = '';
    
    // Удаляем пустые строки из массива строк
    $rows = array_filter($rows, function($value){
        return trim($value) !== '';
    });

    // Объединяем строки в одну текстовую переменную
    foreach ($rows as $row) {
        $dataText .= $row;
    }

    // Получаем заголовок из первой строки
    $header = str_getcsv($rows[0], ";");

    // Объединяем битые строки
    $combinedRows = [];
    $currentRow = '';
    foreach ($rows as $line) {
        $line = trim($line);
        if (!empty($line)) {
            if (!empty($currentRow)) {
                $currentRow .= $line;
            } else {
                $currentRow = $line;
            }
        } else {
            if (!empty($currentRow)) {
                $combinedRows[] = $currentRow;
                $currentRow = '';
            }
        }
    }

    // Преобразуем объединенные строки в ассоциативные массивы
    $data = [];
    foreach ($combinedRows as $line) {
        $lineData = str_getcsv($line, ";");
        if (count($lineData) == count($header)) {
            $data[] = array_combine($header, $lineData);
        }
    }

    return $data;
}



function generateSQL($flight, $type) {
    $date = getRandomDate('2024-07-01', '2024-08-31');
    $airline = $flight['airline'];
    $ch_code = $flight['ch_code'];
    $num_code = rand(1000, 9999);
    $dep_time = getRandomTime();
    $departure_destination = rand(1, 6);
    $arrival_destination = rand(1, 6);
    while ($arrival_destination == $departure_destination) {
        $arrival_destination = rand(1, 6);
    }
    $time_taken = str_replace(['h', 'm'], [':', ':00'], $flight['time_taken']);
    $stop = trim(preg_replace('/\s+/', ' ', $flight['stop']));
    $arr_time = calculateArrivalTime($dep_time, $time_taken);
    $price = 0; // Будет рассчитано позже с помощью ИИ

    return "INSERT INTO `flights` (`id`, `date`, `airline`, `ch_code`, `num_code`, `dep_time`, `departure_destination`, `time_taken`, `stop`, `arr_time`, `arrival_destination`, `price`, `type`) VALUES (NULL, '$date', '$airline', '$ch_code', '$num_code', '$dep_time', '$departure_destination', '$time_taken', '$stop', '$arr_time', '$arrival_destination', '$price', '$type');";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['businessFile']) && isset($_FILES['economyFile'])) {
        $businessFile = $_FILES['businessFile']['tmp_name'];
        $economyFile = $_FILES['economyFile']['tmp_name'];

        $business_flights = getFlightData($businessFile);
        $economy_flights = getFlightData($economyFile);
        $sql_queries = [];

        for ($i = 0; $i < 100; $i++) {
            $business_flight = $business_flights[array_rand($business_flights)];
            $economy_flight = $economy_flights[array_rand($economy_flights)];

            $sql_queries[] = generateSQL($business_flight, 1);
            $sql_queries[] = generateSQL($economy_flight, 2);
        }

        file_put_contents('flights.sql', implode("\n", $sql_queries));
        echo "SQL queries generated and saved to flights.sql";
    } else {
        echo "Please upload both CSV files.";
    }
}
?>