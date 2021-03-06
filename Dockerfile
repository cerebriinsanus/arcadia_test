FROM php:7.4-fpm
RUN apt-get update && apt-get install -y --no-install-recommends \
git \
zlib1g-dev \
libxml2-dev \
libpng-dev \
libpq-dev \
libzip-dev \
vim curl debconf git apt-transport-https apt-utils \
build-essential locales acl mailutils wget nodejs zip unzip \
gnupg gnupg1 gnupg2 \
sudo \
ssh \
&& docker-php-ext-install \
zip \
opcache \
gd \
intl
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN usermod -u 1000 www-data
RUN usermod -a -G www-data root
RUN mkdir -p /var/www
RUN chown -R www-data:www-data /var/www
RUN mkdir -p /var/www/.composer
RUN chown -R www-data:www-data /var/www/.composer
WORKDIR /var/www/project/
COPY composer.json ./
COPY composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-dev
COPY . .
RUN composer dump-autoload --optimize && \
	composer run-script post-install-cmd
RUN chown -R www-data:www-data /var/www/project/var
RUN chown -R www-data:www-data /var/www/project/public
