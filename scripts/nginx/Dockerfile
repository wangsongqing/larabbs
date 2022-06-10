FROM nginx:alpine
MAINTAINER LIUWENCAN <phenye@gmail.com>
RUN adduser -D -H -u 5000 -s /bin/sh www
RUN rm /etc/nginx/conf.d/default.conf
ADD nginx.conf /etc/nginx/
ADD backend.conf /etc/nginx/sites-available/
VOLUME /var/www
CMD ["nginx"]
