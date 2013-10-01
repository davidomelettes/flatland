#!/bin/bash

echo "DROPPING DATABASE..."
dropdb flatland;
echo "CREATING DATABASE..."
createdb flatland;
echo "MIGRATING DATABASE..."
./migrate.sh
