FROM richarvey/nginx-php-fpm:latest

# Set PHP upload limits
RUN echo "post_max_size = 20M" >> /usr/local/etc/php/conf.d/uploads.ini && \
    echo "upload_max_filesize = 20M" >> /usr/local/etc/php/conf.d/uploads.ini

COPY . .

# Image config
ENV SKIP_COMPOSER=1 
ENV WEBROOT=/var/www/html/public
ENV PHP_ERRORS_STDERR=1
ENV RUN_SCRIPTS=1
ENV REAL_IP_HEADER=1

# Laravel config
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["/start.sh"]