<?php  
include_once __DIR__ . '/settings.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_MAGIC_QUOTES);

$sql = "select * from user where email = :email";
$st = $db->prepare($sql);
$st->bindParam(':email', $email, PDO::PARAM_STR);
$st->execute();

while ($row = $st->fetch()) {
	//進行解碼
	if (password_verify($pwd, $row['password'])) {
		$_SESSION['id'] = $row['id'];
		setcookie('warning','登入成功！');
		header("Location: ./index.php");
		exit;
	}
	else{
		setcookie('warning','帳號密碼錯誤！');
		header("Location: ./login.php");
		exit;
	}
}







?>