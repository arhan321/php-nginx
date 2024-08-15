# Gunakan image resmi PHP dengan PHP-FPM
FROM php:8.3-fpm

# Setel direktori kerja
WORKDIR /var/www/html

# Install paket dan ekstensi PHP yang dibutuhkan
RUN apt-get update -y && apt-get install -y \
    libmariadb-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    zip \
    unzip \
    wget

# Konfigurasikan dan install ekstensi GD secara terpisah untuk menangkap error spesifik
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd

# Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install ekstensi PHP lainnya
RUN docker-php-ext-install pdo_mysql mysqli mbstring exif zip pcntl bcmath calendar intl gettext opcache sockets

# Set "Require all granted" in vhost configuration
# RUN sed -i 's/Require .*/Require all granted/' /etc/apache2/sites-available/000-default.conf

# Salin kode lokal ke dalam container
COPY . /var/www/html

# Setel kepemilikan dan izin
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Expose port 9000 untuk PHP-FPM
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
