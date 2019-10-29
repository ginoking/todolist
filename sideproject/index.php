<?php
include_once __DIR__ . '/settings.php';

if (!is_login()) {
	setcookie('warning','尚未登入');
	header('Location: ./login.php');
	exit;
}
$time = date("Y-m-d");
$user_id = $_SESSION['id'];

$sql = "select c_name from user where id = :user_id";
$st = $db->prepare($sql);
$st->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$st->execute();
$user_name = $st->fetch()['c_name'];

//更新狀態
if (!isset($_COOKIE['update'])) {
	$sql = "update mission set is_done = 2, done_at = '逾期' where deadline < :time and is_done = '0'";
	$st = $db->prepare($sql);
	$st -> bindParam(':time',$time,PDO::PARAM_STR);
	$st -> execute();

	setcookie('update', true, time()+86400);
}

$sql = "select * from mission where user_id = :user_id";
$st = $db ->prepare($sql);
$st->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$st->execute();

$todolist = $st -> fetchall();


echo $twig->render(
	'index.html', [
		'todolist' => $todolist,
		'user_name' => $user_name
	]
);

?>