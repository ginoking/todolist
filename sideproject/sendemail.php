<?php  
include_once __DIR__ . '/settings.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

if ($email == '') {
	$_SESSION['message'] = '信箱要輸入';
	header('Location: login.php');
	exit;
}

$sql = "select email,c_name from user where email = :email";
$st = $db->prepare($sql);
$st->bindParam(':email',$email,PDO::PARAM_STR);
$st->execute();
$exist = $st->rowCount();
while ($row = $st->fetch()) {
	$name = $row['c_name'];
}
$new_pwd = substr(str_shuffle('gino_sideproject'), 0, 7);

if (!$exist) {
	$_SESSION['message'] = '信箱還沒註冊過喔!';
	header('Location: login.php');
	exit;
}

$mail->addAddress($email, '金沅禹'); // 收件的信箱
//因為標題中文會亂碼
$mail->Subject = "=?utf-8?B?" . base64_encode('重置密碼') . "?=";
$content = "Hi! {$name} 你的新密碼是<b>{$new_pwd}</b><br>請馬上進入系統更改密碼。";

$mail->Body = $content;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
	$_SESSION['message'] = "系統遇到些許問題";
	header('Location: login.php');
	exit;

} else {
	$_SESSION['message'] = "新密碼已寄出，請確認";
	header('Location: login.php');
	exit;
}

// try {

// 	$db->beginTransaction();

// 	$sql = "select * from user where email = :email";
// 	$st = $db->prepare($sql);
// 	$st->bindParam(':email',$email,PDO::PARAM_STR);

// 	$st->execute();
// 	$db->commit();
	
// 	$_SESSION['message'] = '事項新增成功！';
// 	header('Location: ./index.php');


// } catch (PDOException $e) {
// 	$error = $e->getMessage();
// 	setcookie('warning',$error);
// 	header("Location: ./index.php");
// 	exit;
// }




?>