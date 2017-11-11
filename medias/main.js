function refreshSize(bord) {
	if( typeof( window.innerWidth ) == 'number' )
		hauteur = window.innerHeight;
	else if( document.documentElement && document.documentElement.clientHeight )
		hauteur = document.documentElement.clientHeight;
	hauteur = hauteur - bord;
	document.getElementById('content').style.height = hauteur + 'px';
	document.getElementById('rendu').style.height = hauteur + 'px';
}

$(window).resize(function() {
	refreshSize(156);

});

$(function() {
	
	refreshSize(156);

	$('#plus-infos').click(function() {
		window.open(document.getElementById('plus-infos').href);
		return false;
	});
	
	$("#trad").click(function () {
		var message = $('#content').val();
		$.post("inc/ajax-load.php", {content:message}, function(data) {
			$('#rendu-pre').html(data); 
		});
	});


	$("#export-window").dialog({
		autoOpen: false,
		height: 200,
		width: 300,
		modal: true,
		buttons: {
			'Exporter': function() {
				var src = $('#export-select').val();
				$('#export').val(src);
				$("#corps").submit();
				$('#export-select').val('');
				$('#export').val('');
				$("#export-window").dialog('close');
			}
		}

	});
	
	$("#export-btn").click(function() {
		$("#export-window").dialog('open');
	});


	$('#export-window').css('display', 'block');
	$('#trad').css('display', 'inline');
	$('#export-btn').css('display', 'inline');
	
});
