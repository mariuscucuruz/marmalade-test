FROM php:8.0-alpine

ARG user=1000
ARG uid=1000

# Install system dependencies
RUN apt-get update -yyq && apt-get install -yyq --no-install-recommends \
    openssl git curl zip unzip \
    libmcrypt-dev libpng-dev libonig-dev libxml2-dev libzip-dev \
    libfreetype6-dev libjpeg62-turbo-dev libpng-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

## Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

EXPOSE 9000

CMD ["php-fpm"]
