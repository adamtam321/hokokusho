<?php
require_once('Model/DBconnect.php');
if (!isset($_SESSION)) {
    session_start();
}
unset($_SESSION['student']);
header('Location: ?View=login');
?>