<?
$con = new PDO("mysql:host=localhost;dbname=dtair", "root", "");
session_start();
if (isset($_SESSION['rand'])) {
    unset($_SESSION['rand']);
} else {
    $_SESSION['rand'] = 'abobus';
}
$session_temp = $_SESSION;
function validate_input($text) {
    return htmlspecialchars(trim($text));
}
session_write_close();