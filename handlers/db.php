<?
$con = new PDO("mysql:host=127.0.0.1;dbname=dtair", "root", "");
session_start();
if (isset($_SESSION['rand'])) {
    unset($_SESSION['rand']);
} else {
    $_SESSION['rand'] = 'abobus';
}
function validate_input($text) {
    return htmlspecialchars(trim($text));
}
session_write_close();