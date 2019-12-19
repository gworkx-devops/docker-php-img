#! /bin/bash

# running php app interactively using apache-alpine 
#
docker container run -it --name www-php-00 -p 8998:80 -v $PWD/source-code:/var/www/html:ro gworkx/img:php-workshop-alpine bash
