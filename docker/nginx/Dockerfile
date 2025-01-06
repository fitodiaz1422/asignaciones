FROM nginx:1.19.6-alpine

WORKDIR /var/www/html

COPY . /var/www/html

RUN rm /etc/nginx/conf.d/default.conf

COPY ./docker/nginx/default.conf /etc/nginx/conf.d

RUN mkdir -p /var/www/html/storage/app
RUN chown -R www-data:www-data /var/www/html/storage
RUN chmod -R 775 /var/www/html/storage

RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage
