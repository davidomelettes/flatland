BEGIN;

-- Enables UUID data type
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Allows use of complex cryptographic hash algorithms like SHA256
CREATE EXTENSION IF NOT EXISTS "pgcrypto";

-- Creates sha256() hashing function
CREATE OR REPLACE FUNCTION sha256(text) returns text AS $$
	SELECT encode(digest($1, 'sha256'), 'hex')
	$$ LANGUAGE SQL STRICT IMMUTABLE;

COMMIT;
