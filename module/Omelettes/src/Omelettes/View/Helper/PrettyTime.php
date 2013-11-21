<?php

namespace Omelettes\View\Helper;

class PrettyTime extends AbstractPrettifier
{
	public function __invoke($iso8601)
	{
		$now = time();
		$then = strtotime($iso8601);
		$diff = $then - $now;
		
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
					if (date('Y-m-d', $now) === date('Y-m-d', $then)) {
						return sprintf('Today, %s', date('H:i', $then));
					} else {
						return sprintf('Yesterday, %s', date('H:i', $then));
					}
					$today = date('Y-m-d');
					return date('H:i:s, Y-m-d', $then);
				default:
					return date('Y-m-d', $then);
			}
		} else {
			// Present/Future
			switch (1) {
				default:
					return date('Y-m-d', $then);
			}
		}
	}
	
}
