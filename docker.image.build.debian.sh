#! /bin/bash

# initial image baking step
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
