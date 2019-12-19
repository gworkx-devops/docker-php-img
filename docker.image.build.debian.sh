#! /bin/bash

# image baking - debian
#
docker image build -f Dockerfile.debian.php -t gworkx/img:php-workshop-debian .
