<?php

mb_internal_encoding('UTF-8');

define('C_COMMENT', '008000');
define('C_KEYWORD', '0000ff');
define('C_MODULE', '0000ff');
define('C_QUOTE', 'a31515');
define('C_TITRE', '008000');



function pre($array) {
	$ansi = array('', '│', '║');
	$c = '';
	for($i = 0; $i != count($array); $i++) {
		$c .= $ansi[$array[$i]];
	}
	return $c;
}


function c(&$str) {
	$temp = '';
	$start = false;
	for($i = 0; strlen($str) != $i; $i++) {
		if($str[$i] !== ' ')
			$start = true;
		if($start)
			$temp .= $str[$i];
	}
	$str = $temp;
}


function moduleC($m, $color) {
	$arg = explode(';', $m[3]);
	$nom = $arg[0];
	if($m[2] == 'fonct1') {
		$b1 = $m[1].span("o─". str_repeat('─', mb_strlen($nom)) ."─o", C_MODULE , $color);
		$b2 = $m[1].span("│ ". $nom ." │", C_MODULE, $color);
		$b3 = $m[1].span("o─". str_repeat('─', mb_strlen($nom)) ."─o", C_MODULE , $color);
	}
	elseif($m[2] == 'fonct2') {
		$b1 = $m[1].span("o─". str_repeat('─', mb_strlen($nom)) ."─o", C_MODULE , $color);
		$b2 = $m[1].span("║ ". $nom ." │", C_MODULE, $color);
		$b3 = $m[1].span("o─". str_repeat('─', mb_strlen($nom)) ."─o", C_MODULE , $color);
	}
	else {
		$b1 = $m[1].span("┌─". str_repeat('─', mb_strlen($nom)) ."─┐", C_MODULE , $color);
		$b2 = $m[1].span("│ ". $nom ." │", C_MODULE, $color);
		$b3 = $m[1].span("└─". str_repeat('─', mb_strlen($nom)) ."─┘", C_MODULE , $color);
	}

	if($arg[1] != '')
		$b1 .= span("↓ ", C_MODULE, $color).$arg[1];
	if($arg[2] != '')
		$b3 .= span("↓ ", C_MODULE, $color).$arg[2];

	return $b1 . "\r\n" . $b2 . "\r\n" . $b3;
}


function parseLine($str) {
	$r = '';
	$com = false;
	$q = 0;
	$slash = 0;

	for($i = 0; $i <= strlen($str); $i++) {
		$c = $str[$i];

		if($c == '/')
			$slash++;
		else
			$slash = 0;

		if($c == '"') {
			$q++;
		}

		if(!$com && $q == 1) {
			$r .= '<span style="color:#'. C_QUOTE .'">';
			$q = 2;
		}

		$r .= $c;

		if(!$com && $q == 3) {
			$r .= '</span>';
			$q = 0;
		}


		if($slash == 2) {
			$r .= '<span style="color:#'. C_COMMENT .'">';
			$com = true;
		}


		if($i == strlen($str) && $com)
			$r .= '</span>';


	}
	return preg_replace('#//<span(.+)>(.+)</span>#iU', '<span$1>//$2</span>', $r);
}


function parser($da, $color = false, $rn = true) {
	if($rn)
		$lignes = explode("\r\n", $da);
	else {
		$lignes = str_replace("\r\n", "\n", explode("\n", $da));
	}

	$r = '';
	$array = array(0);
	$niv = 0;

	foreach($lignes as $l) {
		c($l);

		if($color)
			$l = parseLine($l);

		if(preg_match('#^---\*#isU', $l)) {
			$l = preg_replace('#^---\*(.+)$#isU', '┌───*'. span('$1', C_TITRE, $color), $l);
			$r .= pre($array) . $l;
			$array[++$niv] = 1;
		}

		//	FIN
		elseif(preg_match('#^___#isU', $l)) {
			$l = preg_replace('#^___#isU', '└──', $l);
			$array[$niv--] = 0;
			$r .= pre($array) . $l;
		}
		elseif(preg_match('#^===#isU', $l)) {
			$l = preg_replace('#^===#isU', '╙──', $l);
			$array[$niv--] = 0;
			$r .= pre($array) . $l;
		}

		//	IF
		elseif(preg_match('#^if#isU', $l)) {
			$l = preg_replace('#if#isU', '┌── '. span('if', C_KEYWORD, $color), $l);
			$r .= pre($array) . colorANDOR($l, $color);
			$array[++$niv] = 1;
		}

		elseif(preg_match('#^do#isU', $l)) {
			$l = preg_replace('#^do#isU', '╔══ do', $l);
			$r .= pre($array) . colorANDOR($l, $color);
			$array[++$niv] = 2;
		}

		elseif(preg_match('#^(Sortir|Obtenir|Liberer|Ouvrir|Fermer|Lire|Ecrire)#isU', $l)) {
			$l = preg_replace('#^(Sortir|Obtenir|Liberer|Ouvrir|Fermer|Lire|Ecrire)#isU', span('$1', C_KEYWORD, $color), $l);
			$r .= pre($array) . ' ' . $l;
		}

		else
			$r .= pre($array) . ' ' . $l;

		if($rn)
			$r = $r . "\r\n";
		else
			$r = $r . "\n";
	}

	$r = preg_replace('#╔══ do(.+)\(#iU', '╔══ '. span('do$1', C_KEYWORD, $color) .'(', $r);
	$r = preg_replace('#╔══ do#iU', '╔══ '. span('do', C_KEYWORD, $color), $r);
	$r = preg_replace('#╙── while(.+)\(#iU', '╙── '. span('while$1', C_KEYWORD, $color) .'(', $r);

	$r = preg_replace('#\[(\S+)\]ENT#iU', span('[', C_KEYWORD, $color ) . '$1'. span(']<sub>ENT</sub>', C_KEYWORD, $color ), $r);


	$ansi = array('<=' => '≤', '>=' => '≥', '!=' => '≠', '->' => '→');
	$r = str_replace('│ elseif', '├── '. span('if', C_KEYWORD, $color), $r);
	$r = str_replace('│ else', '├── '. span('else', C_KEYWORD, $color), $r);
	foreach($ansi as $r1 => $r2) {
		$r = str_replace($r1, $r2, $r);
	}

	if($color) {
		$r = preg_replace_callback('#([│ ║]+)\[(module|fonct1|fonct2)=(.+)\]#isU', 'parser_module_C', $r);
	}
	else {
		$r = preg_replace_callback('#([│ ║]+)\[(module|fonct1|fonct2)=(.+)\]#isU', 'parser_module_NC', $r);
	}

	return $r;
}

function colorANDOR($str, $color) {
	if($color) {
		$keywords = array('OR', 'AND');
		foreach($keywords as $k) {
			$str = str_replace($k, span($k, C_KEYWORD, $color), $str);
		}
	}
	return $str;
}

function span($str, $colorName, $color) {
	if($color) {
		return '<span style="color:#'. $colorName .'">'. $str .'</span>';
	}
	else {
		return $str;
	}
}

function parser_module_NC($m) {
	return moduleC($m, false);
}

function parser_module_C($m) {
	return moduleC($m, true);
}
?>
