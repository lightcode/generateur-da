<?php
	include 'func.php';

	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	echo str_replace("\n", '<br/>', str_replace("\r\n", "\n", parser(stripcslashes($_POST['content']), true, false)));

?>