FROM debian:stretch-slim

# set environment variables
#
ENV DEBIAN_FRONTEND noninteractive
ENV RELEASE="v1.1"

# set image variables
#
ARG VERSION="php-latest"
ARG PHP_VER="7.3"
ARG IMAGE_CONFIGS="./image-conf-dir"

# set maintenance info
#
LABEL dev.gworkx.tech.version="$RELEASE"
LABEL vendor="Gelwa Workx"
LABEL maintainer="gelwa.workx@gmail.com"
LABEL dev.gworkx.tech.release-date="2019-11-30"
LABEL dev.gworkx.tech.version.is-production="$VERSION"

# set debian packages repos list
#
ADD "${IMAGE_CONFIGS}"/contrib.list  /etc/apt/sources.list.d/contrib.list

RUN set -x \
    && apt-get update -y && apt-get install -y apt-transport-https lsb-release ca-certificates gnupg wget \
    && wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg \
    && echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && apt-get update -y && apt-get upgrade -y \
    && apt-get install -y apt-utils build-essential ssmtp curl unzip vim \
    php"$PHP_VER" php"$PHP_VER"-cli php"$PHP_VER"-common php"$PHP_VER"-mysql php"$PHP_VER"-pgsql php"$PHP_VER"-sqlite3 \
    php"$PHP_VER"-mbstring php"$PHP_VER"-intl php"$PHP_VER"-geoip php"$PHP_VER"-apcu php"$PHP_VER"-memcached \
    php"$PHP_VER"-opcache php"$PHP_VER"-imap php"$PHP_VER"-bz2 php"$PHP_VER"-ldap php"$PHP_VER"-readline \
    php"$PHP_VER"-redis php"$PHP_VER"-ssh2 php"$PHP_VER"-soap php"$PHP_VER"-phar php"$PHP_VER"-xml php"$PHP_VER"-xmlrpc \
    php"$PHP_VER"-xsl php"$PHP_VER"-imagick php"$PHP_VER"-gd php"$PHP_VER"-json php"$PHP_VER"-curl php"$PHP_VER"-zip

# clean up APT when done
#
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# setup runtime php directives
#
ADD "${IMAGE_CONFIGS}"/php.ini /etc/php/7.3/apache2/php.ini
ADD "${IMAGE_CONFIGS}"/php-ssmtp.ini /etc/php/7.3/mods-available/ssmtp.ini

RUN cd /etc/php/"$PHP_VER"/apache2/conf.d && ln -s /etc/php/"$PHP_VER"/mods-available/ssmtp.ini 20-ssmtp.ini
RUN cd /etc/php/"$PHP_VER"/cli/conf.d && ln -s /etc/php/"$PHP_VER"/mods-available/ssmtp.ini 20-ssmtp.ini

#
# add PHP composer
ADD https://getcomposer.org/download/1.9.1/composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

# Install PHPUnit
RUN composer require --dev phpunit/phpunit:"^5.7|^6.0"

# setup runtime apache server
ADD "${IMAGE_CONFIGS}"/apache2.conf /etc/apache2/apache2.conf
RUN a2enmod rewrite && a2enmod deflate

# post setup
#
EXPOSE 80
ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
