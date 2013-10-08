BEGIN;

CREATE TABLE locales (
	code VARCHAR PRIMARY KEY,
	name VARCHAR NOT NULL
);

COPY locales (code, name) FROM stdin;
en_GB	English (United Kingdom)
en_US	English (United States)
fr_FR	French (France)
de_DE	German (Germany)
it_IT	Italian (Italy)
es_ES	Spanish (Spain)
\.

ALTER TABLE users ADD COLUMN locale VARCHAR NOT NULL REFERENCES locales(code) DEFAULT 'en_GB';

CREATE TABLE user_secondary_locales (
	user_key UUID NOT NULL REFERENCES users(key),
	locale_code VARCHAR NOT NULL REFERENCES locales(code),
	PRIMARY KEY (user_key, locale_code)
);

COMMIT;
