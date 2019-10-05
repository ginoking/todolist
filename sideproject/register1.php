<?php  
include_once __DIR__ . '/settings.php';
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_MAGIC_QUOTES);

try {

	$db->beginTransaction();

	$sql = "insert into user (name,email,password) values (:name,:email,:pwd)";
	$st = $db->prepare($sql);
	//目前遇到這裡變數的數量不對，不知道為何，可能眼睛有問題＝＝
	$st->bindParam(':name',$name,PDO::PARAM_STR);
	$st->bindParam(':eamil',$eamil,PDO::PARAM_STR);
	$st->bindParam(':pwd',$pwd,PDO::PARAM_STR);
	$st->execute();

	$error = $st->errorInfo();
	print_r($error);
	$db->commit();


} catch (PDOException $e) {
	error_log($e->getMessage());
	exit();	
}
?>	