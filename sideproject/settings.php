<?php  
require_once "vendor/autoload.php";

date_default_timezone_set("Asia/Taipei");
header('content-type:text/html; charset=utf8');
session_start();


//資料庫連線
$db_ms = "mysql";
$db_host = "localhost";
$db_name = "sideproject";
$user = "root";
$pwd = "";

try {
	$db = new PDO("mysql:host={$db_host};dbname={$db_name};", $user, $pwd);
} catch (PDOException $e) {
	error_log($e->getMessage());
	exit;
}

//twig
$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, []);



include_once __DIR__.'/lib/lib.php'; // 一些常用的function
?>