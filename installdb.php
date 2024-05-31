<?php
include_once "db.php";
$sql = file_get_contents("dtair.sql");
$con->exec($sql);
header("Location:logout.php");
exit;