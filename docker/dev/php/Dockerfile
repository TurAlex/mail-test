FROM php:7.2-fpm-stretch

RUN apt-get update \
    && apt-get install libfontconfig1 -y \
    && apt-get install supervisor -y \
    && apt-get install libfontconfig1 -y \
    && apt-get install --reinstall procps -y \
#    && ACCEPT_EULA=Y apt-get install -y msodbcsql17 mssql-tools unixodbc-dev \
    && pecl install xdebug-2.7.1 \
    && docker-php-ext-enable xdebug

RUN apt update \
	&& apt install -y \
	    sudo \
		zip \
		unzip \
		git \
		nano \
		wget \
		mysql-client \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libwebp-dev \
        libvpx-dev \
		zlib1g-dev \
		libicu-dev \
		libpng-dev \
		libxpm-dev \
		libmemcached-dev \
		g++ \
		cron \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer --version

# Run docker-php-ext-install for available extensions
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd \
           --with-gd \
           --with-webp-dir \
           --with-jpeg-dir \
           --with-png-dir \
           --with-zlib-dir \
           --with-xpm-dir \
           --with-freetype-dir \
    && docker-php-ext-install gd \
    && docker-php-ext-install pdo pdo_mysql opcache zip intl sockets pcntl


ADD ./docker/dev/php/php.ini /usr/local/etc/php/php.ini

COPY ./docker/dev/php/php_init.sh /usr/bin/
RUN chmod +x /usr/bin/php_init.sh

COPY ./docker/dev/php/supervisor/horizon.conf /etc/supervisor/conf.d
#COPY ./docker/dev/php/supervisor/websockets.conf /etc/supervisor/conf.d
COPY ./docker/dev/php/cron/settings.cron /etc/cron.d
