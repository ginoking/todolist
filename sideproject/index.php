<?php
include_once __DIR__ . '/settings.php';

if (!is_login()) {
	setcookie('warning','尚未登入');
	header('Location: ./login.php');
	exit;
}

$time = date("Y-m-d");
$user_id = $_SESSION['id'];

$sql = "select c_name from user where id = :user_id";
$st = $db->prepare($sql);
$st->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$st->execute();
$user_name = $st->fetch()['c_name'];

//更新狀態
if (!isset($_COOKIE['update'])) {
	$sql = "update mission set is_done = 99, done_at = '逾期' where deadline < :time and is_done = '0'";
	$st = $db->prepare($sql);
	$st -> bindParam(':time',$time,PDO::PARAM_STR);
	$st -> execute();

	setcookie('update', true, time()+86400);
}


$status = filter_input(INPUT_GET, 'status');
$priority_id = filter_input(INPUT_GET, 'priority');

//如果null也會被判定為0，所以用兩個去判斷
if (isset($status) && $status == 0) {
	$sql = "select m.*,p.name from mission m  left join priority p on m.priority = p.id where user_id = :user_id and is_done = 0 order by m.is_done, m.priority";
}
elseif ($status == 1) {
	$sql = "select m.*,p.name from mission m  left join priority p on m.priority = p.id where user_id = :user_id and is_done = 1 order by m.is_done, m.priority";
}
elseif ($status == 99 ) {
	$sql = "select m.*,p.name from mission m  left join priority p on m.priority = p.id where user_id = :user_id and is_done = 99 order by m.is_done, m.priority";
}
elseif ($priority_id == 1) {
	$sql = "select m.*,p.name from mission m  left join priority p on m.priority = p.id where user_id = :user_id and priority = 1 order by m.is_done, m.priority";
}
elseif ($priority_id == 2) {
	$sql = "select m.*,p.name from mission m  left join priority p on m.priority = p.id where user_id = :user_id and priority = 2 order by m.is_done, m.priority";
}
elseif ($priority_id == 3) {
	$sql = "select m.*,p.name from mission m  left join priority p on m.priority = p.id where user_id = :user_id and priority = 3 order by m.is_done, m.priority";
}
else{
	$sql = "select m.*,p.name from mission m  left join priority p on m.priority = p.id where user_id = :user_id order by m.is_done, m.priority";
}

$st = $db ->prepare($sql);
$st->bindParam(':user_id', $user_id, PDO::PARAM_STR);
$st->execute();

$todolist = $st -> fetchall();

$sql = "select * from priority";
$st = $db->prepare($sql);
$st->execute();
while ($row = $st -> fetch()) {
	$priority[] = [
		'name' => $row['name'],
		'id' => $row['id']
	];
}

$message = $_SESSION['message'];
$_SESSION['message'] = '';



echo $twig->render(
	'index.html', [
		'todolist' => $todolist,
		'user_id' => $user_id,
		'user_name' => $user_name,
		'priority' => $priority,
		'message' => $message,
	]
);

?>