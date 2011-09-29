function architectSwitchTab(tab)
{
	$$('.architectTabsContent').invoke('hide');
	$('architect'+tab).show();
	
	$$('#architectTabs li').invoke('removeClassName', 'selected');
	$('architectTab'+tab).addClassName('selected');
}
