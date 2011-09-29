<?php header("content-type: application/x-javascript"); ?>
$('a[title]').qtip({
	style: {
		name: '<?php echo addslashes($_GET['color']); ?>', tip: true,
		textAlign: 'center'
	},
	position: { corner: {
		target: '<?php echo addslashes($_GET['tooltip_target']); ?>',
		tooltip: '<?php echo addslashes($_GET['tooltip_position']); ?>'
	} }
})