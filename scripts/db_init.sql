BEGIN;

-- Enables UUID data type
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Allows use of complex cryptographic hash algorithms like SHA256
CREATE EXTENSION IF NOT EXISTS "pgcrypto";

-- Creates sha256() hashing function
CREATE OR REPLACE FUNCTION sha256(text) returns text AS $$
	SELECT encode(digest($1, 'sha256'), 'hex')
	$$ LANGUAGE SQL STRICT IMMUTABLE;

-- Create user and acl tables so console users have an identity to work with
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
	acl_role VARCHAR NOT NULL REFERENCES acl_roles(role),
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

COMMIT;
