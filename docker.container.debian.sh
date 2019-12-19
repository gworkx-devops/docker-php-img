#! /bin/bash

# running php app in detach mode using apache-debian
#
docker container run -d --name www-php-01 -p 8999:80 -v $PWD/source-code:/var/www/html:ro gworkx/img:php-workshop-debian
