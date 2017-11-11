<?php
	if(empty($_GET['da'])) {
		$car = 'azertyuiopqsdfghjklmwxcvbn0123456789';

		for($i = 0; $i != 6; $i++) {
			$code .= $car[mt_rand(0, strlen($car))];
		}
		file_put_contents(SAVE_PATH . $code .'.txt', $_POST['content']);
		header('Location:./?da='.$code .'&autosave');
	}
	else {
		$code = $_GET['da'];
		file_put_contents(SAVE_PATH . $code .'.txt', $_POST['content']);
	}
?>
