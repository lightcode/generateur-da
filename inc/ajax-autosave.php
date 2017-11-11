<?php
	include 'func.php';

	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	file_put_contents('../save/'. $_POST['id'] .'.txt', str_replace("\n", "\r\n", $_POST['content']));

?>