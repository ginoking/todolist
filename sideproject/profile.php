<?php
include_once __DIR__ . '/settings.php';


if (!is_login()) {
	setcookie('warning','尚未登入');
	header('Location: ./login.php');
	exit;
}
$user_id = $_SESSION['id'];
$sql = "select * from user where id = :user_id";
$st = $db->prepare($sql);
$st->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$st->execute();
while ($row = $st->fetch()) {
	$user_name = $row['c_name'];
	$e_name = $row['e_name'];
	$job_title = $row['job_title'];
	$motto = $row['motto'];
	$des = $row['description'];
	$job_des = $row['job_description'];
	$sticker = $row['sticker'];
	$bg_img = $row['bg_img'];
}

$message = $_SESSION['message'];
$_SESSION['message'] = '';


echo $twig->render(
	'profile.html', [
		'user_id' => $user_id,
		'user_name' => $user_name,
		'e_name' => $e_name,
		'motto' => $motto,
		'job_title' => $job_title,
		'des' => $des,
		'job_des' => $job_des,
		'sticker' => $sticker,
		'bg_img' => $bg_img,
		'message' => $message,
	]
);

?>