FROM php:8.1-apache

# Install PDO MySQL driver and tools
RUN apt-get update \
    && apt-get install -y zip unzip git libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHPUnit
RUN composer global require phpunit/phpunit ^10 --no-interaction \
    && ln -s /root/.composer/vendor/bin/phpunit /usr/local/bin/phpunit