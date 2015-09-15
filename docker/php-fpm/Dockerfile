FROM php:5.6.13-fpm
MAINTAINER Aleksey Kiselev "yakudgm@gmail.com"

RUN apt-get update
RUN apt-get install -y git-core curl
RUN apt-get install -y zlib1g-dev \
        && docker-php-ext-install zip

VOLUME /var/www
COPY init.sh /init.sh
CMD sh /init.sh
