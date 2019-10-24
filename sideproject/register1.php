<?php  
include_once __DIR__ . '/settings.php';
$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pwd1 = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_MAGIC_QUOTES);
$pwd2 = filter_input(INPUT_POST, 'pwd2', FILTER_SANITIZE_MAGIC_QUOTES);


if ($pwd1 != $pwd2) {
	setcookie('warning','兩次密碼不相同！');
	header("Location: /register.php");
	exit;
}

//判斷email是否存在

$sql = "select * from user where email = :email";
$st = $db -> prepare($sql);
$st->bindParam(':email',$email,PDO::PARAM_STR);
$st->execute();
$exist = $st->rowCount();

if ($exist == 0) {
	try {

		$db->beginTransaction();

		$sql = "insert into user (name,email,password) values (:name, :email, :pwd)";
		$st = $db->prepare($sql);
		$st->bindParam(':name',$name,PDO::PARAM_STR);
		$st->bindParam(':email',$email,PDO::PARAM_STR);
		$st->bindParam(':pwd',$pwd1,PDO::PARAM_STR);
		
		$st->execute();

		$db->commit();

		header("Location: /login.php");

	} catch (PDOException $e) {
		error_log($e->getMessage());
		exit();	
	}
}
else{
	setcookie('warning','帳號已經被申請過了');
	header("Location: /register.php");
	exit;
}

?>	