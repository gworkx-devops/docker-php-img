## HOW TO BUILD A DOCKER IMAGE

+ Building a PHP 7 image running on Apache HTTPD 2.4 webserver:

```sh
#! /bin/bash

#
# baking the php docker image
#
# docker image build -f Dockerfile.debian.php -t gworkx/img:php-workshop-7.3 .
# docker image build --no-cache -f Dockerfile.debian.php -t gworkx/img:php-workshop-7.3 .

# image baking - alpine
#
docker image build -f Dockerfile.alpine.php -t gworkx/img:php-workshop-alpine .

# image baking - debian
#
docker image build -f Dockerfile.debian.php -t gworkx/img:php-workshop-debian .

# image baking - CakePHP
#
docker image build -f Dockerfile.cake -t gworkx/img:php-workshop-cakephp .

#
# push the image to a remote registry
#
docker push gworkx/img:php-workshop-latest
```
## HOW TO SPIN A CONTAINER FROM THE IMAGE

+ To instantiate a docker container from the image execute the following steps:

```sh
#! /bin/bash

#
# start apache web server with a php module 
#
docker container run -d --name www-php-00 -p 8999:80 -v $PWD/source-code:/var/www/html gworkx/img:php-workshop-debian

#
# start apache web server with a php module in an interactive mode 
#
docker container run -it --name www-php-01 -p 8998:80 -v $PWD/source-code:/var/www/html gworkx/img:php-workshop-debian bash
```
