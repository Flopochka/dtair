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
header("Location:/control");
exit;
