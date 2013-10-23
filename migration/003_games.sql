BEGIN;

CREATE TABLE games (
	key UUID PRIMARY KEY,
	name VARCHAR NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT now(),
	updated TIMESTAMP NOT NULL DEFAULT now(),
	created_by UUID NOT NULL REFERENCES users(key),
	updated_by UUID NOT NULL REFERENCES users(key)
);

CREATE TABLE game_publishers (
	key UUID PRIMARY KEY,
	name VARCHAR NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT now(),
	updated TIMESTAMP NOT NULL DEFAULT now(),
	created_by UUID NOT NULL REFERENCES users(key),
	updated_by UUID NOT NULL REFERENCES users(key)
);

CREATE TABLE game_designers (
	key UUID PRIMARY KEY,
	name VARCHAR NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT now(),
	updated TIMESTAMP NOT NULL DEFAULT now(),
	created_by UUID NOT NULL REFERENCES users(key),
	updated_by UUID NOT NULL REFERENCES users(key)
);

CREATE TABLE game_variants (
	key UUID PRIMARY KEY,
	game_key UUID NOT NULL REFERENCES games(key),
	language_code CHAR(2) NOT NULL REFERENCES locale_languages(code),
	edition INT NOT NULL DEFAULT 1,
	name VARCHAR NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT now(),
	updated TIMESTAMP NOT NULL DEFAULT now(),
	created_by UUID NOT NULL REFERENCES users(key),
	updated_by UUID NOT NULL REFERENCES users(key),
	description TEXT,
	release_date DATE,
	publisher_key UUID REFERENCES game_publishers(key)
);

CREATE TABLE game_variant_designers (
	game_key UUID NOT NULL REFERENCES games(key),
	designer_key UUID NOT NULL REFERENCES game_designers(key)
);

COMMIT;
