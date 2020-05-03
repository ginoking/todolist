<?php  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
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


//PHPMailer

$mail = new PHPMailer;
$mail->Charset='UTF-8';
// $mail->SMTPDebug = SMTP::DEBUG_SERVER; // 開啟偵錯模式

$mail->isSMTP(); // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'gino4279245@cycu.org.tw'; // SMTP username
$mail->Password = 'kinggino4279245'; // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587; // TCP port to connect to

//研究寄信人怎麼不讓中文便亂碼
$mail->setFrom('gino4279245@gmail.com', 'Gino'); //寄件的Gmail

$mail->isHTML(true); // Set email format to HTML

//twig
$loader = new \Twig\Loader\FilesystemLoader('templates/');
$twig = new \Twig\Environment($loader, []);



include_once __DIR__.'/lib/lib.php'; // 一些常用的function
?>