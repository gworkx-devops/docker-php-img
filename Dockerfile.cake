FROM gworkx/img:php-latest

COPY ./checkout-code/source-code /var/www/html
COPY ./checkout-code/ssmtp /etc/ssmtp

RUN chown -R www-data.www-data source-code/ && \
    chown -R 999.999 db-archive
