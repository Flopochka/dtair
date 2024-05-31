<?
include_once "db.php";
session_start();
session_destroy();
session_write_close();
$_SESSION['popup'] = "Вы успешно вышли";
header("location: index.php");
exit;