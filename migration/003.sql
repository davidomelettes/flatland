BEGIN;

CREATE TABLE games (
	key UUID PRIMARY KEY,
	name VARCHAR NOT NULL,
	description TEXT,
	home_locale VARCHAR NOT NULL REFERENCES locales(code),
	created TIMESTAMP NOT NULL DEFAULT now(),
	updated TIMESTAMP NOT NULL DEFAULT now(),
	created_by UUID REFERENCES users(key),
	updated_by UUID REFERENCES users(key),
	min_age INT,
	max_age INT,
	expansion_for UUID REFERENCES games(key)
);

CREATE TABLE game_players (
	game_key UUID NOT NULL REFERENCES games(key),
	players INTEGER NOT NULL,
	with_custom_rules BOOLEAN NOT NULL DEFAULT true,
	with_game UUID REFERENCES games(key),
	PRIMARY KEY (game_key, players)
);

COMMIT;
