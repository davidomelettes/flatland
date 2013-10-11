<?php

namespace OmelettesLocale\Model;

use Omelettes\Model\AbstractModel;

class Locale extends AbstractModel
{
	protected $code;
	protected $name;
	protected $native;
	protected $countryCode;
	protected $countryName;
	protected $countryNative;
	protected $languageCode;
	protected $languageName;
	protected $languageNative;
	protected $currencyCode;
	protected $currencyName;
	protected $currencySymbol;
	protected $currencyDecimals;
	protected $currencyDecimalSeparator;
	protected $currencyThousandsSeparator;
	protected $dateCode;
	protected $dateFormat;
	protected $datePhpFormat;
	
	public function exchangeArray($data)
	{
		$this->setCode(isset($data['code']) ? $data['code'] : null)
			->setName(isset($data['name']) ? $data['name'] : null)
			->setNative(isset($data['native']) ? $data['native'] : null)
			->setCountryCode(isset($data['country_code']) ? $data['country_code'] : null)
			->setCountryName(isset($data['country_name']) ? $data['country_name'] : null)
			->setCountryNative(isset($data['country_native']) ? $data['country_native'] : null)
			->setLanguageCode(isset($data['language_code']) ? $data['language_code'] : null)
			->setLanguageName(isset($data['language_name']) ? $data['language_name'] : null)
			->setLanguageNative(isset($data['language_native']) ? $data['language_native'] : null)
			->setCurrencyCode(isset($data['currency_code']) ? $data['currency_code'] : null)
			->setCurrencyName(isset($data['currency_name']) ? $data['currency_name'] : null)
			->setCurrencySymbol(isset($data['currency_symbol']) ? $data['currency_symbol'] : null)
			->setCurrencyDecimals(isset($data['currency_decimals']) ? $data['currency_decimals'] : null)
			->setCurrencyDecimalSeparator(isset($data['currency_decimal_separator']) ? $data['currency_decimal_separator'] : null)
			->setCurrencyThousandsSeparator(isset($data['currency_thousands_separator']) ? $data['currency_thousands_separator'] : null)
			->setDateCode(isset($data['date_code']) ? $data['date_code'] : null)
			->setDateFormat(isset($data['date_format']) ? $data['date_format'] : null)
			->setDatePhpFormat(isset($data['date_php_format']) ? $data['date_php_format'] : null)
		;
	
		return $this;
	}
	
	public function getArrayCopy()
	{
		return array(
			'code'							=> $this->code,
			'name'							=> $this->name,
			'native'						=> $this->native,
			'name'							=> $this->name,
			'country_code'					=> $this->countryCode,
			'country_name'					=> $this->countryName,
			'country_native'				=> $this->countryNative,
			'language_code'					=> $this->languageCode,
			'language_name'					=> $this->languageName,
			'language_native'				=> $this->languageNative,
			'currency_code'					=> $this->currencyCode,
			'currency_name'					=> $this->currencyName,
			'currency_symbol'				=> $this->currencySymbol,
			'currency_decimals'				=> $this->currencyDecimals,
			'currency_decimal_separator'	=> $this->currencyDecimalSeparator,
			'currency_thousands_separator'	=> $this->currencyThousandsSeparator,
			'date_code'						=> $this->dateCode,
			'date_format'					=> $this->dateFormat,
			'date_php_format'				=> $this->datePhpFormat,
		);
	}
	
	public function setCode($code)
	{
		$this->code = (string)$code;
	
		return $this;
	}
	
	public function getCode()
	{
		return $this->code;
	}
	
	public function setName($name)
	{
		$this->name = $name;
	
		return $this;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setNative($native)
	{
		$this->native = $native;
	
		return $this;
	}
	
	public function getNative()
	{
		return $this->native;
	}
	
	public function setCountryCode($code)
	{
		$this->countryCode = $code;
	
		return $this;
	}
	
	public function getCountryCode()
	{
		return $this->countryCode;
	}
	
	public function setCountryName($name)
	{
		$this->countryName = $name;
	
		return $this;
	}
	
	public function getCountryName()
	{
		return $this->countryName;
	}
	
	public function setCountryNative($native)
	{
		$this->countryNative = $native;
	
		return $this;
	}
	
	public function getCountryNative()
	{
		return $this->countryNative;
	}
	
	public function setLanguageCode($code)
	{
		$this->languageCode = $code;
	
		return $this;
	}
	
	public function getLanguageCode()
	{
		return $this->languageCode;
	}
	
	public function setLanguageName($name)
	{
		$this->languageName = $name;
	
		return $this;
	}
	
	public function getLanguageName()
	{
		return $this->languageName;
	}
	
	public function setLanguageNative($native)
	{
		$this->languageNative = $native;
	
		return $this;
	}
	
	public function getLanguageNative()
	{
		return $this->languageNative;
	}
	
	public function setCurrencyCode($code)
	{
		$this->currencyCode = $code;
	
		return $this;
	}
	
	public function getCurrencyCode()
	{
		return $this->currencyCode;
	}
	
	public function setCurrencyName($name)
	{
		$this->currencyName = $name;
	
		return $this;
	}
	
	public function getCurrencyName()
	{
		return $this->currencyName;
	}
	
	public function setCurrencySymbol($symbol)
	{
		$this->currencySymbol = $symbol;
	
		return $this;
	}
	
	public function getCurrencySymbol()
	{
		return $this->currencySymbol;
	}
	
	public function setCurrencyDecimals($decimals)
	{
		$this->currencyDecimals = (int)$decimals;
	
		return $this;
	}
	
	public function getCurrencyDecimals()
	{
		return $this->currencyDecimals;
	}
	
	public function setCurrencyDecimalSeparator($separator)
	{
		$this->currencyDecimalSeparator = $separator;
	
		return $this;
	}
	
	public function getCurrencyDecimalSeparator()
	{
		return $this->currencyDecimalSeparator;
	}
	
	public function setCurrencyThousandsSeparator($separator)
	{
		$this->currencyThousandsSeparator = $separator;
	
		return $this;
	}
	
	public function getCurrencyThousandsSeparator()
	{
		return $this->currencyThousandsSeparator;
	}
	
	public function setDateCode($code)
	{
		$this->dateCode = $code;
	
		return $this;
	}
	
	public function getDateCode()
	{
		return $this->dateCode;
	}
	
	public function setDateFormat($format)
	{
		$this->dateFormat = $format;
	
		return $this;
	}
	
	public function getDateFormat()
	{
		return $this->dateFormat;
	}
	
	public function setDatePhpFormat($format)
	{
		$this->datePhpFormat = $format;
	
		return $this;
	}
	
	public function getDatePhpFormat()
	{
		return $this->datePhpFormat;
	}
	
}
