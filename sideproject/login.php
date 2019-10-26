<?php
include_once __DIR__ . '/settings.php';

if (is_login()) {
	setcookie('warning','已經登入囉！');
	header('Location: ./index.php');
	exit;
}

echo $twig->render(
	'login.html', [
		'user_name' => ''
	]
);

?>