FROM php:7.1-fpm

RUN apt-get update && apt-get upgrade -y && apt-get autoremove -y \
    && pecl install xdebug \
    && rm -rf /tmp/pear \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)\n" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on\n" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off\n" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9001\n" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

USER www-data

WORKDIR /var/www