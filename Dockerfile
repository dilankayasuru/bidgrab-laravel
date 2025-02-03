FROM composer:2.2 AS build
WORKDIR /app
COPY . /app

RUN apk --update add --no-cache build-base openssl-dev autoconf \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apk del build-base openssl-dev autoconf \
    && rm -rf /var/cache/apk/*

RUN apk add --no-cache nodejs npm

RUN npm install && npm run build

RUN composer install --no-dev --optimize-autoloader

FROM php:8.2-fpm-alpine
WORKDIR /app
COPY --from=build /app /app

RUN apk --update add --no-cache build-base openssl-dev autoconf \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apk del build-base openssl-dev autoconf \
    && rm -rf /var/cache/apk/*

FROM nginx:latest
COPY --from=build /app /app
COPY nginx.conf /etc/nginx/conf.d/default.conf
EXPOSE 80

ENV APP_ENV=production
ENV APP_DEBUG=false

CMD ["nginx", "-g", "daemon off;"]