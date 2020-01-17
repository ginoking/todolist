<?php  
include_once __DIR__ . '/settings.php';
echo $id = filter_input(INPUT_GET, 'id');

try {
	$sql = "delete from mission where id = :id";
	$st = $db->prepare($sql);
	$st->bindParam(':id', $id, PDO::PARAM_STR);
	$st->execute();

	setcookie('warning','刪除成功！');
	header("Location: ./index.php");
	exit;

	
} catch (PDOException $e) {
	error_log($e->getMessage());
		exit();	
}

?>	