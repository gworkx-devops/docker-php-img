FROM gworkx/img:php-latest

COPY ./checkout-code/source-code /var/www/html
COPY /etc/ssmtp /etc/ssmtp

RUN chown -R www-data.www-data /var/www/html

WORKDIR /var/www/html
RUN composer up
