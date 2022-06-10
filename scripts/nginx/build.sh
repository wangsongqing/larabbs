#!/bin/sh

if [ $# -gt 1 ] ; then
    docker build -t app-nginx:$1 -t  app-nginx:latest  .
else
    docker build -t  app-nginx:latest  .
fi
