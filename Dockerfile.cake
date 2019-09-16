FROM gworkx/img:php-latest

COPY ./checkout-code/source-code /var/www/html
COPY ./checkout-code/ssmtp /etc/ssmtp
