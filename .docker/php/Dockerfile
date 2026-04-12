FROM php:8.4-apache

ARG UID=1000
ARG GID=1000

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git \
    curl \
    vim \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    default-mysql-client \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN a2enmod rewrite

RUN groupmod -g ${GID} --non-unique www-data \
    && usermod -u ${UID} --non-unique www-data

COPY .docker/php/docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
