<?php

namespace Omelettes\View\Helper;

class PrettyTime extends AbstractPrettifier
{
	public function __invoke($iso8601)
	{
		$now = time();
		$time = strtotime($iso8601);
		$diff = $time - $now;
		
		if ($diff < 0) {
			// Past
			$diff = abs($diff);
			switch (1) {
				case $diff < 30:
					return 'Just now';
				case $diff < 3600:
					$minutes = ceil($diff / 60);
					return sprintf('%d minute%s ago', $minutes, $minutes === 1 ? '' : 's');
				case $diff < 86400:
					return date('H:i:s, Y-m-d', $time);
				default:
					return date('Y-m-d', $time);
			}
		} else {
			// Present/Future
			switch (1) {
				default:
					return date('Y-m-d', $time);
			}
		}
	}
	
}
