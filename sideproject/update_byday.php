<?php 
$start = include_once __DIR__ . '/settings.php';

ignore_user_abort();//關閉瀏覽器後繼續執行
set_time_limit(0);
$interval = 60*60*24;

while ($start) {
	$today = date('Y-m-d');

	$db->beginTransaction();
	$sql = "update mission set is_done = 99 where deadline < :time and is_done != 1";
	$st = $db->prepare($sql);
	$st->bindParam(':time',$today,PDO::PARAM_STR);
	$st->execute();
	$db->commit();

	sleep($interval);
}

exit;

?>