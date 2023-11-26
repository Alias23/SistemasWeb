FROM php:7.2.2-apache
RUN docker-php-ext-install pdo_mysql
#RUN apt-get update && \ 
#apt-get install -y apache2
#RUN echo "ServerName 127.0.0.1" >> /etc/apache2/apache2.conf
RUN a2enmod rewrite && a2enmod ssl && a2enmod socache_shmcb && a2enmod headers
RUN service apache2 restart
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN rm -rf /etc/apache2/sites-enabled/000-default.conf
