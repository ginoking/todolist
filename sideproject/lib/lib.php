<?php
//確認登入狀態
function is_login(){
	if (isset($_SESSION['id'])) {
		return true;
	}
	else{
		return false;
	}
}

function strong_password($pwd){
	// Given password
	$password = $pwd;

	// Validate password strength
	$uppercase = preg_match('@[A-Z]@', $password);
	$lowercase = preg_match('@[a-z]@', $password);
	$number    = preg_match('@[0-9]@', $password);
	$specialChars = preg_match('@[^\w]@', $password);

	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
	   return false;
	}else{
	    return true;
	}
}



?>