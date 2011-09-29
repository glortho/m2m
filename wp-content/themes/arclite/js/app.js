(function($) {
	var $container = $('#sidebar-secondary'),
		o = $container.children('li'),
		len = o.length,
		i = len,
		p, t;

	while (i--) {
		p = parseInt(Math.random()*len, 10);
		t = o[i];
		o[i] = o[p];
		o[p] = t;
	}

	$container.empty().html( o.get() );
}(jQuery));