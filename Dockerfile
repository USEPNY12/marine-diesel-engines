FROM php:8.1-apache

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite headers expires

# Set Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html

# Configure Apache to allow .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copy website files
COPY . /var/www/html/

# Create uploads directory
RUN mkdir -p /var/www/html/assets/uploads/products \
    && mkdir -p /var/www/html/assets/uploads/blog \
    && chown -R www-data:www-data /var/www/html/assets/uploads \
    && chmod -R 755 /var/www/html/assets/uploads

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
