FROM dunglas/frankenphp:latest

# Install dependencies, Node.js, npm, and Composer
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && apt-get clean

RUN apt-get update && apt-get install -y \
    libonig-dev \
    && docker-php-ext-install mbstring



# Create an alias for 'symfony console' to represent 'php bin/'
#RUN echo "alias symfony='php bin/'" >> ~/.bashrc
#
## Source the aliases
#RUN echo "source ~/.bashrc" >> ~/.bash_profile

# Install Xdebug
#RUN pecl install xdebug && docker-php-ext-enable xdebug

# Configure Xdebug
#RUN echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/xdebug.ini \
#    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini

# Set the working directory
WORKDIR /app/public
