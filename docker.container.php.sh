#! /bin/bash

# running php app in detach mode using apache-debian
#
docker container run -d --name www-php-02 -p 8080:80 -v $PWD/app-code:/var/www/html gworkx/img:php-workshop-debian
