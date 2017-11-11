<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<link href="medias/style.css" type="text/css" rel="stylesheet" media="screen" />
		<link href="medias/css-jqueryui/base/jquery.ui.all.css" type="text/css" rel="stylesheet" media="screen" />
		<script type="text/javascript" src="medias/jquery-1.4.2.min.js"></script>
		<script type="text/javascript" src="medias/jquery-ui-1.8.1.custom.min.js"></script>
		<script type="text/javascript" src="medias/main.js"></script>
		<title>Générateur de DA</title>
	</head>

	<body>
		<div id="header">
			<div style="float:left">
				<h1>Générateur de <abbr title="Diagramme d'Action">DA</abbr></h1>
				<p><a href="http://lightcode.fr/p54-generateur-da.php" id="plus-infos">Plus d'infos</a></p>
			</div>
			<div style="float:right" id="lightcode">
				<p><a href="http://lightcode.fr">LightCode<span style="color:#333333">.fr</span></a></p>
			</div>
		</div>
		<form id="corps" method="post" action="">

			<div class="btn" style="height:35px;width:100%">

				<!-- Bouton traduire -->
				<input id="trad" style="display:none" name="trad" value="Traduire" title="Traduit votre DA sans le sauvegarder sur le serveur." type="button" />
				<noscript><div style="display:inline"><input name="trad" id="trad" value="Traduire" title="Traduit votre DA sans le sauvegarder sur le serveur." type="submit" /></div></noscript>

				<!-- Bouton sauvegarde -->
				<input name="save" title="Traduit et sauvegarde votre DA sur le serveur pour une utilisation future." value="Enregistrer" type="submit" />

				<!-- Bonton nouveau -->
				<input name="new" value="Nouveau" type="submit" />

				<!-- Exportation -->
				<input id="export" name="export" type="hidden" />
				<input style="display:none" id="export-btn" type="button" value="Exporter" />
				<div style="display:none" id="export-window" title="Exporter">
					<label>
						Objet à exporter
						<select id="export-select">
							<option value="">...</option>
							<optgroup label="Source">
								<option value="src-txt">Format texte</option>
							</optgroup>
							<optgroup label="Traduit">
								<option value="trad-txt">Format texte</option>
								<option value="trad-html">Format HTML</option>
							</optgroup>
						</select>
					</label>
				</div>

				<!-- Ouvertur de DA -->
				ID de votre DA : <input id="open" name="open" value="<?php if(isset($_GET['da'])) : echo $_GET['da']; endif; ?>"/>
				<input name="open_btn" value="Ouvrir" type="submit" />
			</div>

			<div style="float:left;width:49%">
				<p><textarea id="content" cols="" rows="" name="content"><?php if(isset($_POST['content'])) : echo htmlspecialchars(stripcslashes($_POST['content'])); else : echo htmlspecialchars(file_get_contents('example.txt')); endif; ?></textarea></p>
			</div>
			<div style="float:left;width:49%;margin-left:1%;">
				<div id="rendu">
					<pre id="rendu-pre"><?php if(isset($_POST['content'])) : echo parser(stripcslashes($_POST['content']), true); endif; ?></pre>
				</div>
			</div>
		</form>
		<p id="autosave">La sauvegarde automatique ne démarrera qu'après avoir cliqué sur enregistrer.</p>
		<?php if((!empty($_POST['save']) || isset($_GET['autosave'])) && !empty($_GET['da'])) : ?>
			<script type="text/javascript">
			function heure() {
			     var date = new Date();
			     var heure = date.getHours();
			     var minutes = date.getMinutes();
			     var secondes = date.getSeconds();
			     if(minutes < 10)
			          minutes = "0" + minutes;
			     if(secondes < 10)
			          secondes = "0" + secondes;
			     return heure + ':' + minutes + ':' + secondes;
			}

			$("#autosave").hide();
			setInterval("autosave()", 5000);
			function autosave() {
				var post_content = $('#content').val();
				var post_id = '<?php echo $_GET["da"]; ?>';
				$.post("inc/ajax-autosave.php", {content:post_content,id:post_id}, function(data) {
					$("#autosave").show();
					$("#autosave").html("Dernière sauvegarde du DA à " + heure());
				});
			}
			</script>
		<?php endif; ?>
	</body>
</html>
