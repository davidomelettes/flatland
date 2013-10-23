BEGIN;

CREATE TABLE acl_roles (
	role VARCHAR PRIMARY KEY,
	label VARCHAR NOT NULL
);

COPY acl_roles (role, label) FROM stdin;
system	System
user	User
admin	Administrator
super	Super Admin
\.

CREATE TABLE users (
	key UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
	name VARCHAR NOT NULL UNIQUE,
	full_name VARCHAR NOT NULL,
	password_hash VARCHAR NOT NULL,
	salt VARCHAR NOT NULL DEFAULT uuid_generate_v4(),
	name_reset_value VARCHAR,
	name_reset_key UUID,
	name_reset_requested TIMESTAMP,
	password_reset_key UUID,
	password_reset_requested TIMESTAMP,
	enabled BOOLEAN NOT NULL DEFAULT true,
	created TIMESTAMP NOT NULL DEFAULT now(),
	updated TIMESTAMP NOT NULL DEFAULT now(),
	acl_role VARCHAR NOT NULL REFERENCES acl_roles(role) DEFAULT 'user'
);

CREATE TABLE user_logins (
	name VARCHAR NOT NULL REFERENCES users(name),
	series UUID NOT NULL,
	token UUID NOT NULL,
	created TIMESTAMP NOT NULL DEFAULT now(),
	PRIMARY KEY (name, series, token)
);

COPY users (key, name, full_name, salt, password_hash, acl_role) FROM stdin;
deadbeef7a6940e789848d3de3bedc0b	SYSTEM_SYSTEM	System Account	deadbeef7a6940e789848d3de3bedc0b	SYSTEM_SYSTEM	system
feedfacead3e4cc6bd9c501224e24359	SYSTEM_SIGNUP	System Signup Account	feedfacead3e4cc6bd9c501224e24359	SYSTEM_SIGNUP	system
52eb818797564fbea112319d50dc46d0	david@omelett.es	David Edwards	f989b2036a0c4f23aa75ef1c20ed8cc8	30c3478f9cdb04955243dd1971d029795f6337c6ebbf9cf077c7292edca794ac	super
\.

ALTER TABLE users ADD COLUMN created_by uuid REFERENCES users(key);
UPDATE users SET created_by = 'deadbeef-7a69-40e7-8984-8d3de3bedc0b';
ALTER TABLE users ALTER COLUMN created_by SET NOT NULL;
ALTER TABLE users ADD COLUMN updated_by uuid REFERENCES users(key);
UPDATE users SET updated_by = 'deadbeef-7a69-40e7-8984-8d3de3bedc0b';
ALTER TABLE users ALTER COLUMN updated_by SET NOT NULL;

COMMIT;
