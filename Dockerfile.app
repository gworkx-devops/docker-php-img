FROM gworkx/img:php-workshop-debian

COPY ./app-code /var/www/html

RUN chown -R www-data.www-data /var/www/html
