<?php
include_once __DIR__ . '/settings.php';

if (is_login()) {
	setcookie('warning','已經登入囉！');
	header('Location: ./index.php');
	exit;
}

if (isset($_COOKIE['remember_me'])) {

	$remember_me = $_COOKIE['remember_me'];

}
else{
	$remember_me = 0;
}

if ($remember_me) {
	$email = encryptDecrypt($_COOKIE['email'], 1);
	$pwd = encryptDecrypt($_COOKIE['pwd'], 1);
}
else{
	$email = '';
	$pwd = '';
}

if (!isset($_SESSION['message'])) {
	$message = '';
}
else{
	$message = $_SESSION['message'];
	$_SESSION['message'] = '';
}

echo $twig->render(
	'login.html', [
		'user_name' => '',
		'email' => $email,
		'pwd' => $pwd,
		'message' => $message,
	]
);

?>