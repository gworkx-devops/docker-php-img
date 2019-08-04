## HOW TO BUILD A DOCKER IMAGE

+ Building a PHP 7 image running on Apache HTTPD 2.4 webserver:

```sh
#! /bin/bash

#
# baking the gworkx docker image
#
docker image build -t gworkx/img:php7.3 -f Dockerfile.debian.php .

#
# push the image to a remote registry
#
docker push gworkx/img:php7.3
```
## HOW TO SPIN A CONTAINER FROM THE IMAGE

+ To instantiate a docker container from the image execute the following steps:

```sh
#! /bin/bash

#
# start apache web server with a php module 
#
docker container run -d --name www-php-00 -p 8999:80 -v $PWD/source-code:/var/www/html gworkx/img:php7.3

#
# start apache web server with a php module in an interactive mode 
#
docker container run -it --name www-php-01 -p 8998:80 -v $PWD/source-code:/var/www/html gworkx/img:php7.3 bash
```
