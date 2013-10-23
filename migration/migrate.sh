#!/bin/bash

psql flatland < 000_functions.sql
psql flatland < 001_users.sql
psql flatland < 002_locales.sql
psql flatland < 003_games.sql
