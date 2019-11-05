<?php
include_once __DIR__ . '/settings.php';


if (!is_login()) {
	setcookie('warning','尚未登入');
	header('Location: ./login.php');
	exit;
}

$user_id = $_SESSION['id'];
$c_name = filter_input(INPUT_POST, 'c_name', FILTER_SANITIZE_STRING);
$e_name = filter_input(INPUT_POST, 'e_name', FILTER_SANITIZE_STRING);
$job_title = filter_input(INPUT_POST, 'job_title', FILTER_SANITIZE_STRING);
$motto = filter_input(INPUT_POST, 'motto', FILTER_SANITIZE_STRING);
$des = filter_input(INPUT_POST, 'des');
$job_des = filter_input(INPUT_POST, 'job_des');

if(is_uploaded_file($_FILES['img']['tmp_name'])) {
	$sourcePath = $_FILES['img']['tmp_name'];
	$targetPath = "templates/images/".$_FILES['img']['name'];		
	move_uploaded_file($sourcePath,$targetPath);
}

try {
	$db->beginTransaction();

	$sql = "update user set c_name= :c_name,e_name = :e_name,job_title = :job_title,motto = :motto, description = :des, job_description = :job_des, sticker = :sticker where id = :id";
	$st = $db->prepare($sql);
	$st->bindParam(':c_name',$c_name,PDO::PARAM_STR);
	$st->bindParam(':e_name',$e_name,PDO::PARAM_STR);
	$st->bindParam(':des',$des,PDO::PARAM_STR);
	$st->bindParam(':job_des',$job_des,PDO::PARAM_STR);
	$st->bindParam(':motto',$motto,PDO::PARAM_STR);
	$st->bindParam(':job_title',$job_title,PDO::PARAM_STR);
	$st->bindParam(':sticker',$targetPath,PDO::PARAM_STR);
	$st->bindParam(':id',$user_id,PDO::PARAM_STR);


	$st->execute();
	$db->commit();

	setcookie('warning','儲存成功');
	header("Location: ./profile.php");
	exit;

} catch (PDOException $e) {
	error_log($e->getMessage());
	exit();
}


?>