FROM node:18-alpine3.18 as build
WORKDIR /usr/app
COPY --chown=nobody . /usr/app
RUN \
  if [ -f yarn.lock ]; then yarn --frozen-lockfile; \
  elif [ -f package-lock.json ]; then npm ci; \
  elif [ -f pnpm-lock.yaml ]; then yarn global add pnpm && pnpm i --frozen-lockfile; \
  else echo "Lockfile not found." && exit 1; \
  fi
RUN npm run build

FROM php:8.2-fpm-alpine3.18

LABEL maintainer="Berk Yildiz"

ARG ENV=prod

WORKDIR /var/www/html
RUN apk add --no-cache --virtual build-essentials
RUN apk add --no-cache \
    icu-dev icu-libs zlib-dev g++ make automake autoconf libzip-dev \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev unzip postgresql-client libpq-dev bash nginx supervisor curl tzdata htop python3 && \
    docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install pdo_pgsql && \
    docker-php-ext-install intl && \
    docker-php-ext-install opcache && \
    docker-php-ext-install exif && \
    docker-php-ext-install zip

RUN apk del build-essentials && rm -rf /usr/src/php*

RUN wget https://getcomposer.org/composer-stable.phar -O /usr/local/bin/composer && chmod +x /usr/local/bin/composer

# Configure nginx
COPY .dockerconfig/nginx.conf /etc/nginx/nginx.conf

# Configure PHP-FPM
COPY .dockerconfig/fpm-pool.conf /usr/local/etc/php-fpm.d/www.conf
COPY .dockerconfig/php.ini /usr/local/etc/php/conf.d/custom.ini

# Configure supervisord
COPY .dockerconfig/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup document root
RUN mkdir -p /var/www/html
RUN mkdir -p ~/.config/psysh && chmod -R 755 ~/.config
RUN mkdir -p /var/www/html/.config/psysh && chmod -R 755 /var/www/html/.config

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody:nobody /var/www/html && \
  chown -R nobody:nobody /run && \
  chown -R nobody:nobody /var/lib/nginx && \
  chown -R nobody:nobody /var/log/nginx && \
  chown -R nobody:nobody /var/www/html/.config/psysh

USER root

ENV XDG_CONFIG_HOME=/var/www/html/.config/psysh

COPY --chown=nobody . /var/www/html
COPY --from=build --chown=nobody /usr/app/public /var/www/html/public
COPY --chown=nobody ._env.${ENV} /var/www/html/.env

COPY .dockerconfig/start /usr/local/bin/
RUN chmod +x /usr/local/bin/start && chown -R nobody:nobody /usr/local/bin/start

USER nobody
RUN cd /var/www/html && composer install --prefer-dist --no-scripts --no-dev -q -o  --ignore-platform-reqs

# Add application
WORKDIR /var/www/html
EXPOSE 443 80

ENTRYPOINT ["sh"]
CMD ["/usr/local/bin/start"]
