<?php  
include_once __DIR__ . '/settings.php';

$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
$deadline = filter_input(INPUT_POST, 'deadline');
$create_at = date("Y-m-d");
$user_id = $_SESSION['id'];

if ($content == '' || $deadline == '') {
	setcookie('warning','要輸入資料喔！');
	header('Location: ./index.php');
	exit;
}

try {

	$db->beginTransaction();

	$sql = "insert into mission(content,user_id,is_done,create_at, deadline) values(:content, :user_id, 0, :create_at, :deadline)";
	$st = $db->prepare($sql);
	$st->bindParam(':content',$content,PDO::PARAM_STR);
	$st->bindParam(':user_id',$user_id,PDO::PARAM_STR);
	$st->bindParam(':create_at',$create_at,PDO::PARAM_STR);
	$st->bindParam(':deadline',$deadline,PDO::PARAM_STR);

	$st->execute();
	$db->commit();

	setcookie('warning','事項新增成功！');
	header('Location: ./index.php');


} catch (PDOException $e) {
	$error = $e->getMessage();
	setcookie('warning',$error);
	header("Location: ./index.php");
	exit;
}




?>