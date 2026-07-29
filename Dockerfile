FROM php:8.5-cli-bookworm

ENV LANGUAGE en_US.UTF-8
ENV LANG en_US.UTF-8
ENV TERM xterm
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV GIT_COMMITTER_NAME "Nosto CI"
ENV GIT_COMMITTER_EMAIL "devnull@nosto.com"

RUN apt-get update || apt-get update && \
 	apt-get -y -qq install nano tree git unzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# $PHPIZE_DEPS (autoconf, gcc, make, ...) is provided by the official PHP image
# and is required to compile the ast PECL extension. Install it just for the
# build, then purge it to keep the image small.
RUN apt-get update && apt-get install -y --no-install-recommends $PHPIZE_DEPS && \
    pecl install ast && \
    docker-php-ext-enable ast && \
    apt-get purge -y --auto-remove $PHPIZE_DEPS && \
    rm -rf /var/lib/apt/lists/*
