FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        zip \
        mbstring \
        bcmath \
        gd \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .
RUN composer dump-autoload --optimize \
    && php artisan package:discover --ansi || true \
    && mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database

ENV PORT=10000 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    SESSION_DRIVER=file \
    CACHE_STORE=file \
    QUEUE_CONNECTION=sync \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/var/www/html/database/database.sqlite

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=${PORT}
