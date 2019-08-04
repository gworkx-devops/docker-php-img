FROM debian:stretch-slim

# set environment variable
#
ENV DEBIAN_FRONTEND noninteractive

ARG VERSION="php7gwi"

# set maintenance info
#
LABEL dev.gworkx.tech.version="v1.1"
LABEL vendor="Gelwa Workx"
LABEL maintainer="gelwa.workx@gmail.com"
LABEL dev.gworkx.tech.release-date="2019-08-04"
LABEL dev.gworkx.tech.version.is-production="$VERSION"

# set debian packages repos
#
ADD ./image.conf.d/contrib.list  /etc/apt/sources.list.d/contrib.list

RUN set -x \
    && apt-get update -y && apt-get install -y apt-transport-https lsb-release ca-certificates gnupg wget \
    && wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && apt-get update -y && apt-get upgrade -y \
    && apt-get install -y apt-utils build-essential ssmtp curl unzip vim \
    php7.3 php7.3-cli php7.3-common php7.3-mysql php7.3-pgsql php7.3-sqlite3 \
    php7.3-mbstring php7.3-intl php7.3-geoip php7.3-apcu php7.3-memcached php7.3-opcache \
    php7.3-imap php7.3-bz2 php7.3-ldap php7.3-readline php7.3-redis php7.3-ssh2 php7.3-soap \
    php7.3-phar php7.3-xml php7.3-xmlrpc php7.3-xsl \
    php7.3-imagick php7.3-gd php7.3-json php7.3-curl php7.3-zip

# clean up APT when done
#
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# add GEOIP databases
#
#ADD http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz /usr/share/GeoIP/GeoLiteCity.dat.gz
#RUN gunzip /usr/share/GeoIP/GeoLiteCity.dat.gz && chmod +r /usr/share/GeoIP/GeoLiteCity.dat \
#    && ln -s /usr/share/GeoIP/GeoLiteCity.dat /usr/share/GeoIP/GeoIPCity.dat

# setup runtime php
#
ADD ./image.conf.d/php.ini /etc/php/7.3/apache2/php.ini
ADD ./image.conf.d/php-ssmtp.ini /etc/php/7.3/mods-available/ssmtp.ini
RUN cd /etc/php/7.3/apache2/conf.d && ln -s /etc/php/7.3/mods-available/ssmtp.ini 20-ssmtp.ini
RUN cd /etc/php/7.3/cli/conf.d && ln -s /etc/php/7.3/mods-available/ssmtp.ini 20-ssmtp.ini

#
# add PHP composer
ADD https://getcomposer.org/download/1.8.6/composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

# Install PHPUnit
RUN composer require --dev phpunit/phpunit:"^5.7|^6.0"

# setup runtime apache server
#
#ADD ./entrypoint.sh /usr/local/bin/init.sh
#RUN chmod +x /usr/local/bin/init.sh
#
ADD ./image.conf.d/apache2.conf /etc/apache2/apache2.conf
RUN a2enmod rewrite && a2enmod deflate

# post setup
#
EXPOSE 80
#ENTRYPOINT ["/usr/local/bin/init.sh"]
ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
