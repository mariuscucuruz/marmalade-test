FROM php:8.0-fpm-alpine3.13

ARG user=1000
ARG uid=1000

# Install system dependencies
RUN apk update &&  \
    apk add --no-cache \
        openssl  \
        zip  \
        unzip \
        bash \
        curl \
        nano \
        g++ \
        sudo \
        freetds \
        freetype \
        icu \
        libintl \
        libjpeg \
        libpng \
        libpq \
        libwebp \
        libmemcached \
        supervisor \
        libzip \
        composer && \
    apk add --no-cache --virtual build-dependencies \
        curl-dev \
        freetds-dev \
        freetype-dev \
        gettext-dev \
        icu-dev \
        jpeg-dev \
        libpng-dev \
        libwebp-dev \
        libxml2-dev \
        libzip-dev \
        libmemcached-dev \
        zlib-dev \
        autoconf \
        build-base

# Install PHP extensions
RUN docker-php-ext-configure gd \
        --with-freetype=/usr/include/ \
        --with-jpeg=/usr/include/ && \
    docker-php-ext-install \
        bcmath \
        curl \
        ctype \
        fileinfo \
        gettext \
        gd \
        exif \
        iconv \
        intl \
        tokenizer \
        opcache \
        pdo_mysql \
        pdo_dblib \
        soap \
        sockets \
        zip \
        xml \
        pcntl

# Install PECL extensions
RUN pecl install memcached && \
    docker-php-ext-enable memcached

#RUN pecl install redis
#RUN docker-php-ext-enable redis

RUN apk del build-dependencies

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

USER $user

WORKDIR /var/www/html/marmalade
#COPY . /var/www/html/marmalade
COPY .env /var/www/html/marmalade/.env
COPY composer.json /var/www/html/marmalade/composer.json
COPY composer.lock /var/www/html/marmalade/composer.lock

EXPOSE 9000

CMD ["php-fpm", "-F"]
