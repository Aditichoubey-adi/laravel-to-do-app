FROM php:8.2-fpm-alpine

# Set working directory to /var/www
WORKDIR /var/www

# Install system dependencies needed for Laravel and PHP extensions
RUN apk add --no-cache \
    curl \
    git \
    nodejs \
    npm \
    libxml2-dev \
    libzip-dev \
    postgresql-dev \
    sqlite-dev \
    supervisor \
    nginx \
    && docker-php-ext-install -j$(nproc) pdo pdo_mysql opcache \
    && docker-php-ext-install zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the application code into the container
COPY . /var/www

# Install PHP dependencies (Composer)
RUN composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
RUN npm install
RUN npm run build

# Set proper permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy the custom Nginx config (assuming you have a default.conf)
# If you don't have default.conf yet, please comment out the next line or create it.
# COPY default.conf /etc/nginx/conf.d/default.conf

# Expose port 80 (where Nginx will run)
EXPOSE 80

# Define the command to run the services (PHP-FPM and Nginx)
# NOTE: If you commented out the Nginx config above, use 'php-fpm' below.
# CMD sh -c "php-fpm && nginx -g 'daemon off;'"
# Since you might not have the default.conf, let's simplify the command for now:
CMD ["php-fpm"]