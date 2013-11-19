// Handles browsers with no consoles or bad consoles
(function consoleStub() {
	if (!window.console) {
		window.console = {};
	}
	var console = window.console;
	var noop = function () {};
	var methods = ['assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 
	               'error', 'exception', 'group', 'groupCollapsed',
	               'groupEnd', 'info', 'log', 'markTimeline', 'profile',
	               'profileEnd', 'markTimeline', 'table', 'time',
	               'timeEnd', 'timeStamp', 'trace', 'warn'];
	for (var i = 0; i < methods.length; i++) {
		if (!console[methods[i]]) {
			console[methods[i]] = noop;
		}
	}
}());

$(function () {
	$(document).ready(function () {
		console.group('Page head');
		
		// Autocomplete inputs
		$('.autocomplete').each(function(){
			$(this).parents('.form-group').find('label').attr('for', $(this).attr('id'));
			$(this).autocomplete({
				select: function(event, ui) {
					var $i = $(event.target);
					var item = ui.item;
					if (item.value) {
						var $s = $('<p>').addClass('form-control-static bound').text(item.label+' ').append($('<span>').addClass('glyphicon glyphicon-remove')).click(function(){
							$(this).next().val('').show().next().val('');
							$(this).remove();
						});
						$i.hide().before($s).next().val(item.value);
					} else {
						$i.val('').next().val('');
					}
					return false;
				}
			}).click(function () {
				if ($(this).is('.bound')) {
					$(this).val('').removeClass('bound').next().val('');
				}
			});
		});
		
		console.groupEnd();
	});
});
