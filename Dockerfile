# Sử dụng image PHP với Apache
FROM php:7.4-apache

# Cài đặt các dependencies cần thiết
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mysqli

COPY src/ /var/www/html/

EXPOSE 80
