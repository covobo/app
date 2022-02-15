FROM spiralscout/roadrunner:2.0.4 as rr
FROM php:8.0-cli-alpine3.13

# php installation

RUN apk add --no-cache --update \
    libzip-dev curl-dev libxml2-dev icu-dev oniguruma-dev autoconf openssh-client git postgresql-dev alpine-conf \
    && \
    apk add --update --no-cache --virtual .build-deps \
       g++ \
       gcc \
       gnupg \
       libgcc \
       make \
       alpine-sdk \
    && pecl install xdebug-3.0.4 \
    && docker-php-ext-install pdo_pgsql \
    && docker-php-ext-install opcache \
    && docker-php-ext-install sockets

RUN docker-php-source extract \
    && apk -Uu add git rabbitmq-c-dev \
    && git clone --branch v1.11.0 --depth 1 https://github.com/php-amqp/php-amqp.git /usr/src/php/ext/amqp \
    && cd /usr/src/php/ext/amqp && git submodule update --init \
    && docker-php-ext-install amqp

RUN apk del .build-deps

RUN setup-timezone -z "Europe/Moscow"

# Reset php all configs
RUN rm $PHP_INI_DIR/conf.d/*

COPY docker/app/conf.d/ $PHP_INI_DIR/conf.d/

# RoadRunner installation
COPY --from=rr /usr/bin/rr /usr/bin/rr

# Composer installation
ENV COMPOSER_HOME /var/composer
ENV PHP_MEMORY_LIMIT 512
ENV PHP_MAX_EXECUTION_TIME 300

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN mkdir -p /var/composer/cache && chmod 0777 /var/composer/cache
RUN chown -R www-data:www-data /var/composer/cache

RUN chown www-data:www-data /var/www/
RUN chown www-data:www-data /usr/local/bin/

# App installation

WORKDIR /app

COPY . .

RUN composer validate --no-check-all --strict && composer install --prefer-dist --optimize-autoloader --no-dev --no-interaction

RUN bin/console cache:warmup

RUN chown -R www-data:www-data .

USER www-data

CMD ["/usr/bin/rr", "serve", "-d", "-c", ".rr.yaml"]
