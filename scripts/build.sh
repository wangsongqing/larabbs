#!/bin/sh

if [ $# -gt 1 ] ; then
    docker build -t app-backend:$1 -t app-backend:latest  .
else
    docker build -t  app-backend:latest  .
fi
