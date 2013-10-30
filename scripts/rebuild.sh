#!/bin/bash

echo "This script will drop, recreate, and then initialise the application database - USE WITH CAUTION"
echo -n "Are you sure you wish to continue? [y/N]: "
read confirm

if [ "$confirm" != 'y' ]; then
  echo "Stopped"
  exit 0
fi

./db_drop.sh
if [ "$?" -ne "0" ]; then
  exit 1
fi

./db_create.sh
if [ "$?" -ne "0" ]; then
  exit 1
fi

./db_init.sh
if [ "$?" -ne "0" ]; then
  exit 1
fi

echo "Application is now ready to accept console commands"
echo "Execute public/index.php for console command help"
