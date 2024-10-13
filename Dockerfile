# Use the official PHP and Apache image
FROM php:8.2-apache

# Install PHP extensions and other dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libxml2-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl pdo pdo_mysql mysqli


# Enable Apache modules
RUN a2enmod rewrite

# Copy your PHP application files to the container
COPY ./config /var/www/html/config
COPY ./src /var/www/html/src
COPY ./data /var/www/html/data
COPY ./vendor /var/www/html/vendor
COPY ./config/env.config.docker.php /var/www/html/config/env.config.php
COPY ./index.php /var/www/html/index.php
COPY ./.htaccess /var/www/html/.htaccess

RUN chown www-data /var/www/html/data
RUN chown www-data /var/www/html/data/url-shortener.sqlite

# Expose port 80 for Apache
EXPOSE 80

# Start Apache web server
CMD ["apache2-foreground"]
