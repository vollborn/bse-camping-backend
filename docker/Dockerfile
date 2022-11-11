FROM ubuntu:22.04

RUN apt-get update && apt-get upgrade -y
RUN apt-get install software-properties-common ca-certificates lsb-release apt-transport-https tzdata -y

ENV TZ="Europe/Berlin"
ARG PHP_VERSION="8.1"

VOLUME [ "/www" ]

RUN add-apt-repository ppa:ondrej/php && apt-get update

RUN apt-get install -y \
	php${PHP_VERSION} \
	php${PHP_VERSION}-cli \
	php${PHP_VERSION}-fpm \
	php${PHP_VERSION}-mysql \
	php${PHP_VERSION}-mbstring \
	php${PHP_VERSION}-curl

RUN mkdir /var/run/php && \
	ln -s /var/run/php/php${PHP_VERSION}-fpm.sock /var/run/php/php-fpm.sock

RUN apt-get install nginx -y

ADD nginx.conf /etc/nginx/sites-enabled

RUN echo service php${PHP_VERSION}-fpm start >> /startup.sh && \
    echo 'nginx -g "daemon off;"' >> /startup.sh && \
    chmod +x /startup.sh

CMD /startup.sh
