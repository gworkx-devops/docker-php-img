### 1) HOW TO BUILD A DOCKER IMAGE

+ Building a PHP 7 image running on Apache HTTPD 2.4 webserver:

#### BASE IMAGE - ALPINE

```sh
#! /bin/bash

#
# methods to bake a php docker image
#
# docker image build -f Dockerfile.alpine.php -t gworkx/img:php-workshop-alpine .
# docker image build --no-cache -f Dockerfile.alpine.php -t gworkx/img:php-workshop-alpine .

# image baking - alpine
#
docker image build -f Dockerfile.alpine.php -t gworkx/img:php-workshop-alpine .
```

#### BASE IMAGE - DEBIAN/UBUNTU

```sh
#! /bin/bash

# image baking - debian
#
docker image build -f Dockerfile.debian.php -t gworkx/img:php-workshop-debian .
```

#### DOCKER IMAGE REGISTRY

```sh
#! /bin/bash

# sharing docker image - alpine/debian

docker push gworkx/img:php-workshop-alpine
```

### 2) HOW TO RUN DOCKER CONTAINERS

+ To instantiate a docker container from the image execute the following steps:

```sh
#! /bin/bash

#
# start alpine container with php-cli in an interactive mode
#
docker container run -it --name www-php-00 -v $PWD/source-code:/var/www/html:ro gworkx/img:php-workshop-alpine bash

#
# start apache web server with a php module in detached mode
#
docker container run -d --name www-php-01 -p 8999:80 -v $PWD/source-code:/var/www/html:ro gworkx/img:php-workshop-debian
```

### 3) APP CONTAINERIZATION

+ To dockerize a CakePHP application:

```sh
#! /bin/bash

# image baking - CakePHP
#
docker image build -f Dockerfile.app -t gworkx/img:php-workshop-cakephp .
```

### 4) RUN DOCKERIZED APP

+ Working with a dockerized CakePHP application:

```sh
#! /bin/bash

#
# start apache web server with a bind mount CakePHP application in detached mode
#
docker container run -d --name www-php-02 -p 8080:80 -v $PWD/app-code:/var/www/html gworkx/img:php-workshop-debian
```
