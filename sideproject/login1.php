<?php  
include_once __DIR__ . '/settings.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$pwd = filter_input(INPUT_POST, 'password');
$remember_me = filter_input(INPUT_POST, 'remember_me');

$sql = "select * from user where email = :email";
$st = $db->prepare($sql);
$st->bindParam(':email', $email, PDO::PARAM_STR);
$st->execute();

while ($row = $st->fetch()) {
	//進行解碼
	if (password_verify($pwd, $row['password'])) {
		$_SESSION['id'] = $row['id'];
		if ($remember_me) {
			setcookie('remember_me', 1);
			setcookie('email', encryptDecrypt($email, 0) );
			setcookie('pwd', encryptDecrypt($pwd, 0));
		}
		// setcookie('warning','登入成功！');
		$_SESSION['message'] = '登入成功';
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