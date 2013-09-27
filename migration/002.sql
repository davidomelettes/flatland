BEGIN;

CREATE TABLE currencies (
	code VARCHAR PRIMARY KEY,
	name VARCHAR NOT NULL
);

CREATE TABLE trades (
	key UUID PRIMARY KEY,
	name VARCHAR NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT now(),
	created_by UUID NOT NULL REFERENCES users(key),
	value_reserve MONEY NOT NULL,
	value_bin MONEY NOT NULL
);

CREATE TABLE trade_offers (
	key UUID PRIMARY KEY,
	trade_key UUID NOT NULL REFERENCES trades(key),
	created TIMESTAMP NOT NULL DEFAULT now(),
	created_by UUID NOT NULL REFERNCES users(key),
	value_offer MONEY NOT NULL
);

COMMIT;
