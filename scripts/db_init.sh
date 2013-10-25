#!/bin/bash

echo "--INITIALSING DATABASE..."
PGOPTIONS='--client-min-messages=warning' psql -v ON_ERROR_STOP=1 -q -d flatland -f db_init.sql
if [ "$?" -ne "0" ]; then
  exit 1
fi
echo "--DATABASE INITIALISED"
