#!/bin/bash

pwd=${ALIYUN_REGISTRY_PASSWORD}
docker login --username=xmwme@qq.com -p $pwd registry.cn-hangzhou.aliyuncs.com
docker tag app-backend:latest registry.cn-hangzhou.aliyuncs.com/songqing/app-backend:latest
docker push registry.cn-hangzhou.aliyuncs.com/songqing/app-backend:latest


if [ $# -gt 0 ] ; then
  tag=$1
  docker tag app-backend:latest registry.cn-hangzhou.aliyuncs.com/songqing/app-backend:${tag}
  docker push registry.cn-hangzhou.aliyuncs.com/songqing/app-backend:${tag}
fi
