#! /bin/bash

# initial image baking step
#
# docker image build -f Dockerfile.debian.php -t gworkx/img:php7.3 .
# docker image build --no-cache -f Dockerfile.debian.php -t gworkx/img:php7.3 .

# final image baking step
#
docker image build -f Dockerfile.debian.php -t gworkx/img:php7.3 .
