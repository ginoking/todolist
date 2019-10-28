<?php  
include_once __DIR__ . '/settings.php';

$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
$deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);
$mission_id = filter_input(INPUT_POST, 'mission_id');
$check = filter_input(INPUT_POST, 'check');
$update_at = date("Y-m-d");
$done_at = date("Y-m-d");


if($content == '' || $deadline == ''){
	setcookie('warning','要輸入資料喔！');
	header("Location: ./index.php");
	exit;
}



try {

	$db->beginTransaction();

	if ($check == 'on') {
		$sql = "update mission set content = :content, deadline = :deadline, update_at = :update_at, done_at = :done_at, is_done = :check where id = :mission_id";
		$st = $db->prepare($sql);
		$st->bindParam(':content',$content,PDO::PARAM_STR);
		$st->bindParam(':deadline',$deadline,PDO::PARAM_STR);
		$st->bindParam(':update_at',$update_at,PDO::PARAM_STR);
		$st->bindParam(':done_at',$done_at,PDO::PARAM_STR);
		$st->bindValue(':check','1');
		$st->bindParam(':mission_id',$mission_id,PDO::PARAM_STR);
		$st->execute();
		$db->commit();
		setcookie('warning','事項完成');
		header("Location: ./index.php");
		exit;

	}
	else{
		$sql = "update mission set content = :content, deadline = :deadline, update_at = :update_at where id = :mission_id";
		$st = $db->prepare($sql);
		$st->bindParam(':content',$content,PDO::PARAM_STR);
		$st->bindParam(':deadline',$deadline,PDO::PARAM_STR);
		$st->bindParam(':update_at',$update_at,PDO::PARAM_STR);
		$st->bindParam(':mission_id',$mission_id,PDO::PARAM_STR);
		$st->execute();
		$db->commit();
		setcookie('warning','更新成功');
		header("Location: ./index.php");
		exit;
	}
	

} catch (PDOException $e) {
	// error_log($e->getMessage());
	// exit();	
	$error = $e->getMessage();
	setcookie('warning',$error);
	header("Location: ./index.php");
	exit;
}


?>	