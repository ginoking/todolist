<?php  
require_once "vendor/autoload.php";

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


?>