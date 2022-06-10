FROM php:7.4-fpm-alpine
MAINTAINER FANGYUQIANG <fangyuqiang@wufeng-network.com>LABEL description="官方纯净版基础镜像，新增composer，supervisor，以及更多扩展"

# 安装composer
COPY scripts/composer /usr/local/bin/composer
RUN chmod 755 /usr/local/bin/composer
# PHPIZE_DEPS 包含 gcc g++ 等编译辅助类库，完成编译后删除
RUN apk add --no-cache $PHPIZE_DEPS \
    && apk add --no-cache libstdc++ libzip-dev vim\
    && apk update \
    && pecl install redis-5.3.2 \
    && pecl install zip \
    && docker-php-ext-enable redis zip\
    && apk del $PHPIZE_DEPS
# docker-php-ext-install 指令已经包含编译辅助类库的删除逻辑
RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev \
    && apk update \
    && docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/  \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install -j$(nproc) pdo_mysql \
    && docker-php-ext-install -j$(nproc) opcache \
    && docker-php-ext-install -j$(nproc) bcmath
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

#安装supervisor
RUN apk --update add supervisor
# 将源码拷到镜像中
COPY . /var/www/backend
# 确保没有将.env打包进去
RUN if [ -e .env ] ; then rm .env; fi
# 启动脚本，除了php-fpm还有一些额外的配置
COPY scripts/start.sh /start.sh
RUN chmod +x /start.sh
# 用于任务调度的任务
COPY scripts/crontab /var/spool/cron/crontabs/root
# 用于支持worker的启动
COPY scripts/worker.conf /etc/supervisor/supervisord.conf
ADD ./scripts/worker.conf /etc/supervisor/conf.d/worker.conf
RUN chmod +x /usr/bin/supervisorctl
RUN chmod +x -R /etc/supervisord.conf
#添加用户，alpine使用的adduser与其他linux的useradd不同。-S为添加系统用户
RUN adduser -D -H -u 5000 -s /bin/sh www
# 修改属主，确保与php-fpm的用户一致
RUN chown -R www /var/www/backend
RUN chmod 777 -R /var/www/backend/storage
RUN chmod 777 -R /var/www/backend/bootstrap/cache
VOLUME /var/www/backend
CMD ["/start.sh"]
