<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	define('SAVE_PATH', 'save/');

	if(!empty($_POST['export'])) {
		include 'inc/dl.php';
	}
	elseif(!empty($_POST['new'])) {
		header('Location:?new');
	}
	elseif(!empty($_POST['open']) && isset($_POST['open_btn'])) {
		header('Location:./?da='. $_POST['open']);
	}
	else {
		if(!empty($_POST['save']))
			include 'inc/save.php';

		if(isset($_GET['da'])) {

			if(file_exists(SAVE_PATH . $_GET['da'] .'.txt')) {
				$_POST['content'] = file_get_contents(SAVE_PATH . $_GET['da'] .'.txt');
			}
			else {
				header('Location:./?new');
			}

		}

		include 'inc/func.php';

		if(isset($_GET['new'])) {
			$_POST['content'] = '';
		}

		include 'inc/html.php';
	}

?>
