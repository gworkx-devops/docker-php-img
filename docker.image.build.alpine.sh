#! /bin/bash

# image baking - alpine
#
docker image build -f Dockerfile.alpine.php -t gworkx/img:php-workshop-alpine .
