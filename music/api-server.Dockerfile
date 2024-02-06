FROM php:8.2-fpm

RUN apt update && apt install -y openssl

RUN docker-php-ext-install pdo pdo_mysql opcache

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN printf "zend_extension=xdebug.so\n\
xdebug.discover_client_host = false\n\
xdebug.max_nesting_level = 512\n\
xdebug.start_with_request = yes \n\
xdebug.idekey = PHPSTORM_API\n\
xdebug.mode = debug\n\
xdebug.client_host = host.docker.internal\n\
xdebug.client_port = 9003\n" > /usr/local/etc/php/conf.d/xdebug.ini

RUN printf "upload_max_filesize = 100M\n\
post_max_size = 100M\n" > /usr/local/etc/php/conf.d/php.ini

RUN mkdir -p /var/www/api-server/storage/framework \
    && mkdir -p /var/www/api-server/storage/framework/sessions \
    && mkdir -p /var/www/api-server/storage/framework/views \
    && mkdir -p /var/www/api-server/storage/framework/cache \
    && mkdir -p /var/www/api-server/storage/logs

RUN chown -R www-data:www-data /var/www/api-server/storage
