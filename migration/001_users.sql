BEGIN;

CREATE TABLE acl_roles (
	role VARCHAR PRIMARY KEY,
	label VARCHAR NOT NULL
);
INSERT INTO acl_roles (role, label) VALUES ('system', 'System');

CREATE TABLE users (
	key UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
	name VARCHAR NOT NULL UNIQUE,
	created_by UUID NOT NULL REFERENCES users(key),
	updated_by UUID NOT NULL REFERENCES users(key),
	created TIMESTAMP NOT NULL DEFAULT now(),
	updated TIMESTAMP NOT NULL DEFAULT now(),
	full_name VARCHAR NOT NULL,
	salt VARCHAR NOT NULL DEFAULT uuid_generate_v4(),
	password_hash VARCHAR NOT NULL,
	acl_role VARCHAR NOT NULL REFERENCES acl_roles(role) DEFAULT 'user',
	name_reset_value VARCHAR,
	name_reset_key UUID,
	name_reset_requested TIMESTAMP,
	password_reset_key UUID,
	password_reset_requested TIMESTAMP,
	enabled BOOLEAN NOT NULL DEFAULT true
);
INSERT INTO users (key, name, created_by, updated_by, full_name, password_hash, acl_role) VALUES (
	'deadbeef7a6940e789848d3de3bedc0b',
	'SYSTEM_SYSTEM',
	'deadbeef7a6940e789848d3de3bedc0b',
	'deadbeef7a6940e789848d3de3bedc0b',
	'System Account',
	'SYSTEM_SYSTEM',
	'system'
);
INSERT INTO users (key, name, created_by, updated_by, full_name, password_hash, acl_role) VALUES (
	'bedabb1e66ff47f0a3f01f3f45b5c94d',
	'SYSTEM_CONSOLE',
	'deadbeef7a6940e789848d3de3bedc0b',
	'deadbeef7a6940e789848d3de3bedc0b',
	'System Console Account',
	'SYSTEM_CONSOLE',
	'system'
);

CREATE TABLE user_logins (
	name VARCHAR NOT NULL REFERENCES users(name),
	series UUID NOT NULL,
	token UUID NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT now(),
	PRIMARY KEY (name, series, token)
);

COMMIT;
