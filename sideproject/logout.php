<?php
include_once __DIR__ . '/settings.php';
unset($_SESSION['id']);
$_SESSION['message'] = '登出成功!';
header('Location: ./login.php');


?>