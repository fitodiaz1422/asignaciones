FROM php:7.3.33-fpm-bullseye

WORKDIR /var/www/html

RUN usermod -u 33 www-data
RUN groupmod -g 33 www-data

RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libc-client-dev libkrb5-dev

RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl

RUN docker-php-ext-install mysqli pdo pdo_mysql zip gd  -j$(nproc) imap

COPY --from=composer:2.1.8 /usr/bin/composer /usr/local/bin/composer

RUN apt-get clean -y && rm -rf /var/lib/apt/lists/*

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

RUN sed -i 's/post_max_size = 8M/post_max_size = 800M/' /usr/local/etc/php/php.ini
RUN sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 800M/' /usr/local/etc/php/php.ini
RUN sed -i 's/memory_limit = 128M/memory_limit = 8192M/' /usr/local/etc/php/php.ini
RUN sed -i 's/max_execution_time = 30/max_execution_time = 3000/' /usr/local/etc/php/php.ini
RUN sed -i 's/max_input_time = 60/max_input_time = 6000/' /usr/local/etc/php/php.ini

COPY . /var/www/html

RUN mkdir -p /var/www/html/.config
RUN chown -R www-data:www-data /var/www/html/.config
RUN chmod -R 775 /var/www/html/.config

RUN mkdir -p /var/www/html/storage/framework/cache/data
RUN mkdir -p /var/www/html/storage/app
RUN chown -R www-data:www-data /var/www/html
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage
RUN chown www-data:www-data /var/www/html/public
RUN chown www-data:www-data /var/www/html/bootstrap/cache

USER www-data

RUN composer install

RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage

EXPOSE 9000

CMD ["php-fpm"]
