FROM laradock/php-fpm:2.2-7.1
RUN docker-php-ext-install zip
COPY . /var/www
WORKDIR /var/www
RUN bin/composer install

