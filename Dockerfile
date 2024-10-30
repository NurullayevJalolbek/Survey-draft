# PHP 8.3 versiyasi asosida ishga tushamiz, kerakli kengaytmalarni o'rnatamiz
FROM php:8.3-fpm

# PHP bot uchun kerakli kutubxonalar va kengaytmalarni o'rnatamiz
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql

# Container ichida ish katalogini belgilaymiz
WORKDIR /var/www

# Bot fayllarini container ichiga nusxalaymiz
COPY . /var/www

# Ruxsatlarni o'rnatamiz (o'zingizga kerakli qilib sozlang)
RUN chown -R www-data:www-data /var/www

# PHP-FPM uchun portni ochamiz
EXPOSE 9000

# PHP-FPM serverini ishga tushiramiz
CMD ["php-fpm"]
