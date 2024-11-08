FROM php:7.3.33-fpm-bullseye

ARG USERNAME=vscode
ARG USER_UID=1000
ARG USER_GID=$USER_UID

RUN groupadd --gid $USER_GID $USERNAME \
    && useradd --uid $USER_UID --gid $USER_GID -m $USERNAME

RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client libpng-dev libjpeg-dev libfreetype6-dev libzip-dev 

RUN docker-php-ext-install mysqli pdo pdo_mysql zip gd

COPY --from=composer:2.1.8 /usr/bin/composer /usr/local/bin/composer

RUN apt-get clean -y && rm -rf /var/lib/apt/lists/*

USER $USERNAME

EXPOSE 9000

CMD ["php-fpm"]
