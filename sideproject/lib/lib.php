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



?>