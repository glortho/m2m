(function($) {
	var ad_id = '#widget_sp_image-6',
		$ad = $(ad_id).clone(),
		$container = $('#sidebar-secondary'),
		o = $container.children('li').not(ad_id),
		len = o.length,
		i = len,
		p, t;

	while (i--) {
		p = parseInt(Math.random()*len, 10);
		t = o[i];
		o[i] = o[p];
		o[p] = t;
	}

	$container.empty().html( o.get() ).append($ad);
}(jQuery));