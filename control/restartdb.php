<?
include_once "../handlers/db.php";
$stmt = $con->query("SHOW TABLES");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
foreach ($tables as $table) {
    $con->exec("DROP TABLE $table");
}
$sql = file_get_contents("dtair.sql");
$con->exec($sql);
session_start();
session_destroy();
include_once "generateflights.php";
sleep(10);

// $query = $con->prepare("SELECT * FROM `flights`");
// $query->execute();
// $data = $query->fetchAll();

// for ($i=0; $i < 6; $i++) { 
//     $flight_id = array_rand($data);
//     $query = $con->prepare("INSERT INTO favorite_flights (user_id, flight_id) VALUES ('1', ?)");
//     $query->execute([$flight_id]);
// }
header("Location:/control");
exit;