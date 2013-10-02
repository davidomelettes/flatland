BEGIN;

CREATE TABLE locales (
	code VARCHAR PRIMARY KEY,
	name VARCHAR NOT NULL
);

COPY locales (code, name) FROM stdin;
en_GB	English (United Kingdom)
en_US	English (United States)
\.

ALTER TABLE users ADD COLUMN locale VARCHAR NOT NULL REFERENCES locales(code) DEFAULT 'en_GB';

COMMIT;
