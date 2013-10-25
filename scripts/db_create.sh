#!/bin/bash

echo "--CREATING DATABASE..."
createdb flatland
if [ "$?" -ne "0" ]; then
  exit 1
fi
echo "--DATABASE CREATED"
