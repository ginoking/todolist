<?php  
include_once __DIR__ . '/settings.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);


$sql = "select * from user where email = :email and password = :pwd";
$st = $db->prepare($sql);
$st->bindParam(':email',$email,PDO::PARAM_STR);
$st->bindParam(':pwd',$pwd,PDO::PARAM_STR);
$st->execute();

// $error = $st->errorInfo();

$num = $st->rowCount();

if ($num > 0) {
	echo "登入成功";
	//寫session or cookie進去
	//header("Location: /index.php");
}
else{
	echo "fail";
	// header("Location: /login.php");
}





?>