<?php

include_once __DIR__ . '/settings.php';



$message = $_SESSION['message'];
$_SESSION['message'] = '';


echo $twig->render(
	'register.html', [
		'message' => $message
	]
);

?>