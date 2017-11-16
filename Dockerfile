FROM php:7.0.25-cli-jessie

ENV LANGUAGE en_US.UTF-8
ENV LANG en_US.UTF-8
ENV TERM xterm
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /tmp

RUN apt-get update && \
    apt-get -y -qq install nano tree git

RUN git config --global user.name "Nosto CI"
RUN git config --global user.email "devnull@nosto.com"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN cd /tmp && \
    git clone https://github.com/nikic/php-ast.git && \
    cd php-ast && \
    phpize && \
    ./configure && \
    make install && \
    docker-php-ext-enable ast && \
    rm -rf /tmp/php-ast
