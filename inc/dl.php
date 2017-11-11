<?php
	include 'func.php';
	
	if(isset($_GET['da']))
		$fileNom = 'DA_' . $_GET['da'];
	else
		$fileNom = 'da';
	
	header('Content-Type: application/force-download');
	
	if($_POST['export'] == 'trad-html')
		header('Content-disposition: attachment; filename='. $fileNom .'.html');
	else
		header('Content-disposition: attachment; filename='. $fileNom .'.txt');
	
	if($_POST['export'] == 'src-txt')
		echo $_POST['content'];
	elseif($_POST['export'] == 'trad-txt')
		echo parser(stripcslashes($_POST['content']));
	elseif($_POST['export'] == 'trad-html') {
		echo 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">',
				'<html xmlns="http://www.w3.org/1999/xhtml">',
				'<head>',
				'<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />',
				'<title>DA '. $_GET['da'] .'</title>',
				'</head>',
				
				'<body>',
				'<pre>',
				parser(stripcslashes($_POST['content']), true),
				'</pre>',
				'</body>',
				'</html>';
	}
?>