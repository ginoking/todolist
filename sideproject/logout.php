<?php
include_once __DIR__ . '/settings.php';
unset($_SESSION['id']);
setcookie('warning','成功登出');
header('Location: /login.php');


?>