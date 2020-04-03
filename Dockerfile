FROM composer:1 AS builder

COPY composer.json .
COPY composer.lock .

RUN composer install -v --prefer-dist --optimize-autoloader --no-interaction

# -----------------------------------------------------------------------------
FROM php:7-fpm-alpine

ARG MCQ_IP
ARG MCQ_PORT
ARG MCQ_TYPE

# Copy source to image.
COPY --from=builder /app/vendor /var/www/html/vendor
COPY mcquery.php /var/www/html/index.php
