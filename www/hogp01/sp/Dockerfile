FROM php:8.2-fpm

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd bcmath


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

RUN composer update
RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000
RUN php artisan storage:link
CMD php artisan serve --host=0.0.0.0 --port=8000

