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
		console.groupEnd();
	});
});
