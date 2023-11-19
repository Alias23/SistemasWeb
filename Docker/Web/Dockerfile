FROM php:latest
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite && a2enmod ssl && a2enmod socache_shmcb
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN rm -rf /etc/apache2/sites-enabled/000-default.conf
