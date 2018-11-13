FROM php:7.0.25-cli-jessie

ENV LANGUAGE en_US.UTF-8
ENV LANG en_US.UTF-8
ENV TERM xterm
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp
ENV GIT_COMMITTER_NAME "Nosto CI"
ENV GIT_COMMITTER_EMAIL "devnull@nosto.com"

RUN apt-get update && \
    apt-get -y -qq install nano tree git unzip

# Install all core dependencies required for setting up Apache and PHP atleast
RUN         apt-get -y -q install wget libfreetype6-dev libjpeg-dev \
            libmcrypt-dev libreadline-dev libpng-dev libicu-dev default-mysql-client \
            libmcrypt-dev libxml2-dev libxslt1-dev vim  curl \
            supervisor ca-certificates && \
            apt-get -y clean

# Install Apache, MySQL and all the required development and prod PHP modules
RUN         apt-get -y -q install apache2 php7.0 default-mysql-client-core \
            default-mysql-server-core default-mysql-server php7.0-dev php7.0-gd \
            php7.0-mcrypt php7.0-intl php7.0-xsl php7.0-zip php7.0-bcmath \
            php7.0-curl php7.0-mbstring php7.0-mysql php-ast php7.0-soap && \
            apt-get -y clean

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN cd /tmp && \
    git clone https://github.com/nikic/php-ast.git && \
    cd php-ast && \
    phpize && \
    ./configure && \
    make install && \
    docker-php-ext-enable ast && \
    rm -rf /tmp/php-ast
