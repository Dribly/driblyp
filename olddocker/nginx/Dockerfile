FROM nginx:alpine

MAINTAINER Toby Powell-Blyth <toby@powellblyth.com>

ADD nginx.conf /etc/nginx/

ARG PHP_UPSTREAM_CONTAINER=php-fpm
ARG PHP_UPSTREAM_PORT=9000
ARG NGINX_HOSTNAME=${NGINX_HOSTNAME}
ARG HOST_HTTP_PORT=${HOST_HTTP_PORT}
ARG HOST_HTTPS_PORT=${HOST_HTTPS_PORT}

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash \
    && adduser -D -H -u 1000 -s /bin/bash www-data
# Set upstream conf and remove the default conf
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:9000;}" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf
RUN echo "server {    listen 80;    listen [::]:80; server_name ${NGINX_HOSTNAME};    root /var/www/public;    index index.php index.html index.htm;    location / {      try_files \$uri \$uri/ /index.php?\$query_string;    }    location ~ \.php$ {    try_files $uri /index.php =404;    fastcgi_pass php-upstream;    fastcgi_index index.php;    fastcgi_buffers 16 16k;    fastcgi_buffer_size 32k;    fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;    include fastcgi_params;    }    location ~ /\.ht {            deny all;    }     location /.well-known/acme-challenge/ {     root /var/www/letsencrypt/;     log_not_found off;     }     error_log /var/log/nginx/${NGINX_HOSTNAME}_error.log;     access_log /var/log/nginx/${NGINX_HOSTNAME}_access.log;    }    " > /etc/nginx/conf.d/${NGINX_HOSTNAME}_site.conf
CMD ["nginx"]

EXPOSE ${HOST_HTTP_PORT} ${HOST_HTTPS_PORT} 80 443
