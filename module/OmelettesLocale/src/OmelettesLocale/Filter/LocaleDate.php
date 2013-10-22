<?php

namespace OmelettesLocale\Filter;

use Zend\Filter\AbstractFilter;

class LocaleDate extends AbstractFilter
{
	protected $options = array(
		'format' => 'Y-m-d',
	); 
	
	public function __construct($options = null)
	{
		if (null !== $options) {
			if (is_string($options)) {
				$this->setFormat($options);
			} else {
				$this->setOptions($options);
			}
		}
	}
	
	public function setFormat($format)
	{
		$this->options['format'] = $format;
	}
	
	public function filter($value)
	{
		if ('Y-m-d' !== $this->options['format'] && preg_match('/(\d{2})\/(\d{2})\/(\d{4})/', $value, $m)) {
			$year = $m[3];
			$month = $this->options['format'] == 'd/m/Y' ? $m[2] : $m[1];
			$day = $this->options['format'] == 'd/m/Y' ? $m[1] : $m[2];
			// ISO8601
			$value = sprintf('%s-%s-%s', $year, $month, $day);
		}
		return $value;
	}
	
}
