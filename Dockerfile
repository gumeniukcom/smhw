FROM php:7.4-cli-alpine@sha256:b8c0b0e436b6699ba8ca29fa575a4030f90345a30c159a2f27a62780941106e6

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY composer.json /usr/src/myapp/composer.json
WORKDIR /usr/src/myapp
RUN composer install --no-dev --optimize-autoloader

COPY . /usr/src/myapp

CMD [ "php", "./entrypoint.php" ]