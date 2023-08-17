<?php
define('SYSTEM_ROOT', dirname(__FILE__) . '/');
require SYSTEM_ROOT. '../config/config.php';
$host = $dbconfig['host'];
$user = $dbconfig['user'];
$password = $dbconfig['password'];
$dbname = $dbconfig['dbname'];
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die('数据库连接错误');
}
?>