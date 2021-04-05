FROM php:7.4-fpm

RUN apt-get update && apt-get install -y \
libc-client-dev libkrb5-dev \
curl \
wget \
git \
nano iputils-ping \
mariadb-server \
libfreetype6-dev \
libjpeg62-turbo-dev \
libxslt-dev \
libicu-dev \
libmcrypt-dev \
libxml2-dev \
libonig-dev \
libzip-dev \
&& rm -r /var/lib/apt/lists/* \
&& docker-php-ext-install opcache \
&& docker-php-ext-install -j$(nproc) iconv mbstring mysqli pdo_mysql zip pcntl \
&& docker-php-ext-configure gd --with-freetype --with-jpeg \
&& docker-php-ext-install -j$(nproc) gd \
&& docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
&& docker-php-ext-install imap \
&& pecl install xdebug redis \
&& docker-php-ext-enable xdebug redis

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-install xsl
RUN docker-php-ext-install soap

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN wget https://get.symfony.com/cli/installer -O - | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

EXPOSE 8000
RUN groupadd -g 1000 -r developer && useradd -r -m -u 1000 -g developer developer

WORKDIR /var/www/instapro
ADD php.ini /usr/local/etc/php/conf.d/40-custom.ini

USER developer