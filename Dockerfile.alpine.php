FROM httpd:alpine

# set environment variable
#
ARG VERSION="php7gwi-ap"

# set maintenance info
#
LABEL dev.gworkx.tech.version="1.0-beta"
LABEL vendor="Gelwa Workx"
LABEL maintainer="gelwa.workx@gmail.com"
LABEL dev.gworkx.tech.release-date="2018-04-15"
LABEL dev.gworkx.tech.version.is-production="$VERSION"


RUN set -x \
    && apk update && apk upgrade && apk add --no-cache build-base alpine-sdk bash \
    && apk add php7 php7-cli php7-common php7-mysqli php7-mysqlnd php7-pgsql php7-sqlite3 \
    php7-apache2 php7-openssl php7-mbstring php7-intl php7-phar php7-apcu php7-memcached php7-opcache \
    php7-imagick php7-gd php7-mcrypt php7-json php7-curl php7-zlib \
    && rm -rf /var/cache/apk/*
