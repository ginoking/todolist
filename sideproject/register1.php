<?php  
include_once __DIR__ . '/settings.php';
echo $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
echo $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
echo $pwd = filter_input(INPUT_POST, 'pwd', FILTER_SANITIZE_MAGIC_QUOTES);

try {

	$db->beginTransaction();

	$sql = "insert into user (name,email,password) values (:name, :email, :pwd)";
	$st = $db->prepare($sql);
	//email is null?
	$st->bindParam(':name',$name,PDO::PARAM_STR);
	$st->bindParam(':email',$eamil,PDO::PARAM_STR);
	$st->bindParam(':pwd',$pwd,PDO::PARAM_STR);
	
	$st->execute();

	$db->commit();


} catch (PDOException $e) {
	error_log($e->getMessage());
	exit();	
}
?>	