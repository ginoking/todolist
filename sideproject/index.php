<?php
include_once __DIR__ . '/settings.php';

if (!is_login()) {
	setcookie('warning','尚未登入');
	header('Location: ./login.php');
	exit;
}

$user_id = $_SESSION['id'];

$sql = "select * from mission where user_id = :user_id";
$st = $db ->prepare($sql);
$st->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$st->execute();

$todolist = $st -> fetchall();


echo $twig->render(
	'index.html', [
		'todolist' => $todolist,
	]
);

?>