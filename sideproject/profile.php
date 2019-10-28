<?php
include_once __DIR__ . '/settings.php';

$user_id = $_SESSION['id'];
$sql = "select name from user where id = :user_id";
$st = $db->prepare($sql);
$st->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$st->execute();
$user_name = $st->fetch()['name'];



echo $twig->render(
	'profile.html', [
		'user_name' => $user_name
	]
);

?>