#!/bin/sh

pwd=${ALIYUN_REGISTRY_PASSWORD}
docker login --username=phenye -p baba521. registry.cn-hangzhou.aliyuncs.com
docker tag app-nginx:latest registry.cn-hangzhou.aliyuncs.com/songqing/app-nginx:latest
docker push registry.cn-hangzhou.aliyuncs.com/songqing/app-nginx:latest


if [ $# -gt 0 ] ; then
  tag=$1
  docker tag app-nginx:latest registry.cn-hangzhou.aliyuncs.com/songqing/app-nginx:${tag}
  docker push registry.cn-hangzhou.aliyuncs.com/songqing/app-nginx:${tag}
fi
