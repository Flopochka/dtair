<?php
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
    $newRows = [];
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
    $header = ['airline','ch_code','from','stop'];

    // Преобразуем строки в ассоциативные массивы
    $data = [];
    foreach ($newRows as $line) {
        $lineData = str_getcsv($line, ";");
        $lineData = [$lineData[1],$lineData[2],$lineData[5],$lineData[7]];
        if (count($lineData) == count($header)&&$lineData[2]!=null) {
            $data[] = array_combine($header, $lineData);
        }
    }

    $unique_airlines = [];
    $airlines_trigger = [];
    $unique_stops = [];
    $stop_trigger = [];
    $unique_destinations = [];
    $destination_trigger = [];
    foreach ($data as $flight) {
        $airline = $flight['airline'];
        $ch_code = $flight['ch_code'];
        $stop = $flight['stop'];
        $destination = $flight['from'];
        
        if (!$airlines_trigger[$airline]) {
            $airlines_trigger[$airline] = 1;
            $unique_airlines[] = [$airline, $ch_code];
        }
        
        // Добавляем уникальные значения 'stop'
        if (!$stop_trigger[$stop]) {
            $stop_trigger[$stop] = 1;
            $unique_stops[] = $stop;
        }

        if (!$destination_trigger[$destination]) {
            $destination_trigger[$destination] = 1;
            $unique_destinations[] = $destination;
        }
    }
    
    return [$unique_airlines, $unique_stops, $unique_destinations];
}



// Путь к файлам с данными
$businessFilePath = 'buisness.csv';
$economyFilePath = 'economy.csv';

// Получаем данные из файлов
$data = [getFlightData($businessFilePath), getFlightData($economyFilePath)];

$serializedData = serialize($data);
file_put_contents('data.txt', $serializedData);
header("Location:/");
exit;
?>