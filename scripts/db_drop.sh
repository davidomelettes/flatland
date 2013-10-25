#!/bin/bash

echo -n "Are you SURE you wish to drop the application database? [y/N]: "
read confirm;

if [ "$confirm" == "y" ]; then
  echo "--DROPPING DATABASE..."
  dropdb flatland
  if [ "$?" -ne "0" ]; then
    exit 1
  fi
  echo "--DATABASE DROPPED"
fi
