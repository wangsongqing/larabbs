#!/bin/sh

# 用于启动性能采集
# nohup tideways-daemon &

# 执行migration
cd /var/www/backend
php artisan migrate --force
if [ ! -f "public/storage" ] ; then php artisan storage:link; fi

# 下面这2个被注释的命令有助于提高性能，但是可能导致应用不可用，根据需要自己启动
# php artisan optimize
# php artisan api:cache
if [ $? -eq 0 ] ; then
    # 启动php-fpm
    php-fpm
else
   exit 1
fi
