FROM php:7.1.8-fpm

RUN apt-get update && apt-get install -y \
        curl nano zip unzip php-pclzip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir -p /var/logs/language_group

# Set apps home directory.
ENV APP_DIR /app

# Adds the application code to the image
ADD . ${APP_DIR}

# Define current working directory.
WORKDIR ${APP_DIR}

# Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*