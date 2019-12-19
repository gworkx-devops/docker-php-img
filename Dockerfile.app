FROM gworkx/img:php-workshop-debian

COPY ./source-code /var/www/html

RUN chown -R www-data.www-data /var/www/html
