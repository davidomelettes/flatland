BEGIN;

CREATE TABLE locale_countries (
	code CHAR(2) PRIMARY KEY,
	name VARCHAR NOT NULL,
	native VARCHAR NOT NULL
);

COPY locale_countries (code, name, native) FROM stdin;
au	Australia	Australia
ca	Canada	Canada
de	Germany	Deutschland
es	Spain	España
fr	France	France
gb	United Kingdom	United Kingdom
it	Italy	Italia
jp	Japan	日本
us	United States	United States
\.

CREATE TABLE locale_languages (
	code CHAR(2) PRIMARY KEY,
	name VARCHAR NOT NULL,
	native VARCHAR NOT NULL
);

COPY locale_languages (code, name, native) FROM stdin;
de	German	Deutsch
en	English	English
es	Spanish	Español
fr	French	Français
it	Italian	Italiano
ja	Japanese	日本語
\.

CREATE TABLE locale_currencies (
	code CHAR(3) PRIMARY KEY,
	name VARCHAR NOT NULL,
	symbol CHAR(1),
	symbol_prefix BOOLEAN NOT NULL DEFAULT true,
	decimals INT NOT NULL,
	decimal_separator CHAR(1) NOT NULL,
	thousands_separator CHAR(1) NOT NULL
);

COPY locale_currencies (code, name, symbol, decimals, decimal_separator, thousands_separator) FROM stdin;
AUD	Australian Dollar	$	2	.	,
CAD	Canadian Dollar	$	2	.	,
EUR	Euro	€	2	,	.
GBP	Pound Sterling	£	2	.	,
JPY	Japanese Yen	¥	0	.	,
USD	United States Dollar	$	2	.	,
\.

CREATE TABLE locale_date_formats (
	code CHAR(3) PRIMARY KEY,
	format VARCHAR NOT NULL,
	php_format VARCHAR NOT NULL
);

COPY locale_date_formats (code, format, php_format) FROM stdin;
DMY	dd/mm/yyy	d/m/Y
MDY	mm/dd/yyyy	m/d/Y
YMD	yyyy-mm-dd	Y-m-d
\.

CREATE TABLE locales (
	code VARCHAR PRIMARY KEY,
	country_code CHAR(2) NOT NULL REFERENCES locale_countries(code),
	language_code CHAR(2) NOT NULL REFERENCES locale_languages(code),
	currency_code CHAR(3) NOT NULL REFERENCES locale_currencies(code),
	date_code CHAR(3) NOT NULL REFERENCES locale_date_formats(code)
);

COPY locales (code, country_code, language_code, currency_code, date_code) FROM stdin;
de_DE	de	de	EUR	DMY
en_CA	ca	en	CAD	MDY
en_GB	gb	en	GBP	DMY
en_US	us	en	USD	MDY
es_ES	es	es	EUR	DMY
fr_CA	ca	fr	CAD	DMY
fr_FR	fr	fr	EUR	DMY
it_IT	it	it	EUR	DMY
ja_JP	jp	ja	JPY	YMD
\.

CREATE VIEW locales_view AS SELECT locales.*, locale_countries.name as country_name, locale_countries.native as country_native, locale_languages.name as language_name, locale_languages.native as language_native, locale_currencies.name as currency_name, locale_currencies.symbol as currency_symbol, locale_currencies.decimals as currency_decimals, locale_currencies.decimal_separator as currency_decimal_separator, locale_currencies.thousands_separator as currency_thousands_separator, locale_date_formats.format as date_format, locale_date_formats.php_format as date_php_format, locale_languages.name || ' (' || locale_countries.name || ')' as name, locale_languages.native || ' (' || locale_countries.native || ')' as native FROM locales LEFT JOIN locale_countries ON locales.country_code = locale_countries.code LEFT JOIN locale_languages ON locales.language_code = locale_languages.code LEFT JOIN locale_currencies ON locales.currency_code = locale_currencies.code LEFT JOIN locale_date_formats ON locales.date_code = locale_date_formats.code;

ALTER TABLE users ADD COLUMN locale VARCHAR NOT NULL REFERENCES locales(code) DEFAULT 'en_GB';

CREATE TABLE user_secondary_locales (
	user_key UUID NOT NULL REFERENCES users(key),
	locale_code VARCHAR NOT NULL REFERENCES locales(code),
	PRIMARY KEY (user_key, locale_code)
);

CREATE VIEW user_locales_view AS SELECT user_secondary_locales.user_key, locales_view.* FROM user_secondary_locales LEFT JOIN locales_view ON locales_view.code = user_secondary_locales.locale_code;

CREATE rule user_locales_insert AS ON INSERT TO user_locales_view DO INSTEAD INSERT INTO user_secondary_locales (user_key, locale_code) VALUES (NEW.user_key, NEW.code);
CREATE rule user_locales_delete AS ON DELETE TO user_locales_view DO INSTEAD DELETE FROM user_secondary_locales WHERE user_key = OLD.user_key AND locale_code = OLD.code;

COMMIT;
