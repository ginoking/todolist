<?php  
include_once __DIR__ . '/settings.php';
  
echo $twig->render(
	'register.html', []
);

?>