FROM nginx:1.19.6-alpine

WORKDIR /var/www/html

COPY ./public /var/www/html/public

RUN rm /etc/nginx/conf.d/default.conf

COPY ./docker/nginx/default.conf /etc/nginx/conf.d

RUN ln -s /var/www/html/storage/app/public /var/www/html/public/storage
