# PHP 8.3 versiyasi asosida ishga tushamiz, kerakli kengaytmalarni o'rnatamiz
FROM php:8.3-fpm

# PHP bot uchun kerakli kutubxonalar va kengaytmalarni o'rnatamiz
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    wget \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Container ichida ish katalogini belgilaymiz
WORKDIR /var/www

# Bot fayllarini container ichiga nusxalaymiz
COPY . /var/www

RUN composer install


# Tunneling xizmatini o'rnatish uchun kerakli kutubxonalarni o'rnatish
RUN apt-get update && apt-get install -y \
    curl \
    && rm -rf /var/lib/apt/lists/*

# TunnelTo o'rnatish
RUN curl -sSL https://github.com/tnal/tnal/releases/latest/download/tunnelto_linux_amd64 -o /usr/local/bin/tunnelto \
    && chmod +x /usr/local/bin/tunnelto
# Ruxsatlarni o'rnatamiz (o'zingizga kerakli qilib sozlang)
RUN apt-get update && \
    apt-get install -y curl unzip && \
    curl -s https://bin.equinox.io/c/4VmDzA7iaHb/ngrok-stable-linux-amd64.zip -o ngrok.zip && \
    unzip ngrok.zip && \
    mv ngrok /usr/local/bin/ngrok && \
    rm ngrok.zip


RUN chown -R www-data:www-data /var/www


# PHP-FPM uchun portni ochamiz
EXPOSE 80

# PHP-FPM serverini ishga tushiramiz
CMD ["php-fpm"]
