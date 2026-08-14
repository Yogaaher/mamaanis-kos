# ==============================================================================
# Dockerfile - Mama Anis Kos (PHP 8.3 + Apache for Laravel)
# ==============================================================================
FROM php:8.3-apache

# 1. Install System Dependencies & PHP Extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libicu-dev \
    libsqlite3-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql pdo_sqlite gd zip bcmath intl opcache \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Set Apache Document Root to Laravel public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 3. Set Working Directory
WORKDIR /var/www/html

# 4. Copy Project Source Code
COPY . /var/www/html

# 5. Install Composer Dependencies
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 6. Build Frontend Assets (Vite / Tailwind)
RUN if [ -f "package.json" ]; then \
        npm ci || npm install; \
        npm run build; \
        rm -rf node_modules; \
    fi

# 7. Set Permissions for Storage and Cache
RUN mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views storage/logs \
    && chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Expose Port 80
EXPOSE 80

CMD ["apache2-foreground"]
