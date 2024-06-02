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
function generateSQL($data, $type, $con) {
    $current_date = new DateTime();
    $current_date->modify('+1 year');
    $date = getRandomDate(date('Y-m-d'), $current_date->format('Y-m-d'));
    
    $air = array_rand($data[0]);
    $airline = $data[0][$air][0];
    $ch_code = $data[0][$air][1];

    $num_code = rand(100, 9999);
    $dep_time = getRandomTime();
    $time_taken = getRandomTime();
    $departure_destination = rand(1, 6);
    $arrival_destination = rand(1, 6);
    while ($arrival_destination == $departure_destination) {
        $arrival_destination = rand(1, 6);
    }
    $stop = $data[1][array_rand($data[1])];
    $arr_time = calculateArrivalTime($dep_time, $time_taken);
    $price = 0; // Будет рассчитано позже с помощью ИИ
    $query = $con->prepare("INSERT INTO `flights` (`id`, `date`, `airline`, `ch_code`, `num_code`, `dep_time`, `departure_destination`, `time_taken`, `stop`, `arr_time`, `arrival_destination`, `price`, `type`) VALUES (NULL, ?,?,?,?,?,?,?,?,?,?,?,?);");
    $query->execute([$date,$airline,$ch_code,$num_code,$dep_time,$departure_destination,$time_taken,$stop,$arr_time,$arrival_destination,$price,$type]);
    
}

$serializedData = file_get_contents('data.txt');
$data = unserialize($serializedData);
$con = new PDO("mysql:host=localhost;dbname=dtair", "root", "");

for ($i = 0; $i < 50000; $i++) {
    generateSQL($data[0], 1, $con);
    generateSQL($data[1], 2, $con);
}

header("Location:/control");
exit;
?>