<?php
include_once __DIR__ . '/settings.php';

if (!is_login()) {
	setcookie('warning','尚未登入');
	header('Location: /login.php');
	exit;
}

echo $twig->render(
	'index.html', []
);

?>