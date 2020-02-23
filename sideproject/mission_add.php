<?php  
include_once __DIR__ . '/settings.php';

$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
$deadline = filter_input(INPUT_POST, 'deadline');
$priority = filter_input(INPUT_POST, 'priority');
$create_at = date("Y-m-d");
$user_id = $_SESSION['id'];

if ($content == '' || $deadline == '') {
	$_SESSION['message'] = '要輸入資料喔！';
	header('Location: ./index.php');
	exit;
}

if ($deadline < $create_at) {
	$_SESSION['message'] = '時間已經過囉！';
	header('Location: ./index.php');
	exit;
}

try {

	$db->beginTransaction();

	$sql = "insert into mission(content, user_id, priority,is_done ,create_at ,deadline) values(:content, :user_id, :priority, 0, :create_at, :deadline)";
	$st = $db->prepare($sql);
	$st->bindParam(':content',$content,PDO::PARAM_STR);
	$st->bindParam(':user_id',$user_id,PDO::PARAM_STR);
	$st->bindParam(':priority',$priority,PDO::PARAM_STR);
	$st->bindParam(':create_at',$create_at,PDO::PARAM_STR);
	$st->bindParam(':deadline',$deadline,PDO::PARAM_STR);

	$st->execute();
	$db->commit();
	
	$_SESSION['message'] = '事項新增成功！';
	header('Location: ./index.php');


} catch (PDOException $e) {
	$error = $e->getMessage();
	setcookie('warning',$error);
	header("Location: ./index.php");
	exit;
}




?>