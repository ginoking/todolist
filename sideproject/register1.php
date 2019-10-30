<?php  
include_once __DIR__ . '/settings.php';
$c_name = filter_input(INPUT_POST, 'c_name', FILTER_SANITIZE_STRING);
$e_name = filter_input(INPUT_POST, 'e_name', FILTER_SANITIZE_STRING);
$job_title = filter_input(INPUT_POST, 'job_title', FILTER_SANITIZE_STRING);
$motto = filter_input(INPUT_POST, 'motto', FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pwd1 = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_MAGIC_QUOTES);
$pwd2 = filter_input(INPUT_POST, 'pwd2', FILTER_SANITIZE_MAGIC_QUOTES);


if ($pwd1 != $pwd2) {
	setcookie('warning','兩次密碼不相同！');
	header("Location: ./register.php");
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
		//密碼加密
		$pwd = password_hash($pwd1, PASSWORD_DEFAULT);

		$sql = "insert into user (c_name,e_name,email,password,motto,job_title) values (:c_name, :e_name, :email, :pwd, ':motto', :job_title)";
		$st = $db->prepare($sql);
		$st->bindParam(':c_name',$c_name,PDO::PARAM_STR);
		$st->bindParam(':e_name',$e_name,PDO::PARAM_STR);
		$st->bindParam(':email',$email,PDO::PARAM_STR);
		$st->bindParam(':pwd',$pwd,PDO::PARAM_STR);
		$st->bindParam(':motto',$motto,PDO::PARAM_STR);
		$st->bindParam(':job_title',$job_title,PDO::PARAM_STR);
		
		$st->execute();
		$db->commit();
		
		setcookie('warning','註冊成功！請進行登入');
		header("Location: ./login.php");
		exit;

	} catch (PDOException $e) {
		error_log($e->getMessage());
		exit();	
	}
}
else{
	setcookie('warning','帳號已經被申請過了');
	header("Location: ./register.php");
	exit;
}

?>	