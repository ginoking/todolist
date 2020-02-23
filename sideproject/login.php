<?php
include_once __DIR__ . '/settings.php';

if (is_login()) {
	setcookie('warning','已經登入囉！');
	header('Location: ./index.php');
	exit;
}

$remember_me = $_COOKIE['remember_me'];

if ($remember_me) {
	$email = encryptDecrypt($_COOKIE['email'], 1);
	$pwd = encryptDecrypt($_COOKIE['pwd'], 1);
}
else{
	$email = '';
	$pwd = '';
}

$message = $_SESSION['message'];
$_SESSION['message'] = '';

echo $twig->render(
	'login.html', [
		'user_name' => '',
		'email' => $email,
		'pwd' => $pwd,
		'message' => $message,
	]
);

?>